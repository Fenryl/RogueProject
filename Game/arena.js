
// dimensons de la carte
var ROWS = 11,
        COLS = 10,
        GRID_SIZE = 64;
// nombre d'acteurs dans la partie, dont le joueur
var ACTORS = 7;
// liste de tours les acteurs, actorList[0] correspond au joueur
var player,
        actorList,
        playerHUD,
        depthGroup;
// pointe vers chaque acteur et ses positions en X et Y, pour une recherche rapide
var actorMap;
// mapping des touches
var cursors,
        upKey,
        leftKey,
        downKey,
        rightKey,
        spaceKey;



var game = new Phaser.Game(COLS * GRID_SIZE, ROWS * GRID_SIZE, Phaser.AUTO, 'game', { preload: preload, create: create, update: update });


var Map = {
    tiles: null,

    // initialise la carte et détermine les types de cases mur/sol
    initMap: function () {
        map = game.add.tilemap('map');
        map.addTilesetImage('terrains','tileImage');

        layer = map.createLayer('Layer_base');
        layer.resizeWorld();


        Map.tiles = new Array(COLS-1)
        for (var i = 0; i < COLS; i++) {
            Map.tiles[i] = new Array(ROWS-1);
        }

        for (var x = 0; x < COLS; x++) {
            for (var y = 0; y < ROWS; y++) {
                if (x == 0 || x == 9 || y == 0 || y == 9) {
                    Map.tiles[x][y] = 'wall';
                } else {
                    Map.tiles[x][y] = 'ground';
                }
            }
        }
    },

    // détermine si l'acteur peut se rendre sur cette case
    canGo: function (actor, dir) {
        return actor.x + dir.x >= 0 &&
                actor.x + dir.x < COLS &&
                actor.y + dir.y >= 0 &&
                actor.y + dir.y < ROWS &&
                Map.tiles[actor.x + dir.x][actor.y + dir.y] === 'ground';
    }
};

// déplace l'acteur à la position donnée x, y
Actor.prototype.setXY = function (x, y) {
    this.x = x;
    this.y = y;

    this.game.add.tween(this.sprite).to(
            {
                x: x * GRID_SIZE,
                y: y * GRID_SIZE
            },
            150,
            Phaser.Easing.Quadratic.Out,
            true
    )
            .onComplete.add(function() { player.isMoving = false;}, this);

};

// classe Joueur de type Acteur
Player.prototype = new Actor();

// classe Ennemi de type Acteur
Enemy.prototype = new Actor();

// classe générique pour les acteurs
function Actor (game, x, y, keySprite) {
    this.hp = 1;
    this.x = x;
    this.y = y;
    this.isPlayer = null;
    this.damage = 1;
    this.direction = 'left';

    if (game) {
        this.game = game;
        this.sprite = depthGroup.create(x * GRID_SIZE, y * GRID_SIZE, keySprite);
    } else {
        this.game = null;
        this.sprite = null;
    }
}

// classe spécifique au joueur
function Player (game, x, y) {
    Actor.call(this, game, x, y, 'dude');
    this.hp = 3;
    this.isPlayer = true;
    this.damage = 1;
    this.sprite.frame = 3;
}

// classe spécifique à 1 type d'ennemi, ici squelette
function Enemy (game, x, y) {
    Actor.call(this, game, x, y, 'dude');
    this.hp = 1;
    this.isPlayer = false;
    this.damage = 1;
    this.sprite.frame = 2;
}

function initActors (game) {
    // initialise les acteurs positionnés aléatoirement
    actorList = [];
    actorMap = {};
    var actor, x, y;

    var random = function (max) {
        return Math.floor(Math.random() * max);
    };

    // crée une liste de positions valides
    var groundMap = [];
    for (x = 0; x < COLS; x++) {
        for (y = 0; y < ROWS-1; y++) {
            if (Map.tiles[x][y] === 'ground') {
                groundMap.push({x: x, y: y});
            }
        }
    }

    // tire au hasard une position valide et crée un acteur avec ses coordonnées
    for (var e = 0; e < ACTORS; e++) {
        do {
            var r = groundMap[random(groundMap.length)];
            x = r.x;
            y = r.y;
        } while (actorMap[x + '_' + y]);

        actor = (e === 0)
                ? new Player(game, x, y)
                : new Enemy(game, x, y);


        // référence les acteurs dans l'actor List et Map
        actorMap[actor.x + '_' + actor.y] = actor;
        actorList.push(actor);
    }

    // le joueur est le premier acteur de l'actorList
    player = actorList[0];
}

function moveTo (actor, dir) {
    // vérifie si l'acteur peut aller sur la position donnée
    if (!Map.canGo(actor, dir)) {
        return false;
    }

    player.isMoving = true;

    // change l'orientation de l'acteur si déplacement latéral
    if (dir.x === 1 && actor.direction === 'left') {
        actor.sprite.anchor.setTo(1, 0);
        actor.sprite.scale.x *= -1;
        actor.direction = 'right';

    } else if (dir.x === -1 && actor.direction === 'right') {
        actor.sprite.anchor.setTo(0, 0);
        actor.sprite.scale.x *= -1;
        actor.direction = 'left';
    }

    // stock la nouvelle position
    var newKey = (actor.x + dir.x) + '_' + (actor.y + dir.y);

    // si la case de destination a déjà un acteur dessus
    if (actorMap.hasOwnProperty(newKey) && actorMap[newKey]) {

        var victim = actorMap[newKey];

        // empêche les ennemis de s'attaquer entre eux
        if (!actor.isPlayer && !victim.isPlayer) {
            return;
        }

        // l'acteur inflige des dégâts à la victime
        victim.hp -= actor.damage;

        // détermine l'axe de direction
        var axis = (actor.x === victim.x)
                ? 'y'
                : 'x';

        dir = victim[axis] - actor[axis];
        dir = dir / Math.abs(dir); // +1 ou -1

        var pos1 = {}, pos2 = {};

        // 24 correspond à la distance en pixels de l'animation d'attaque
        pos1[axis] = (dir * 24).toString();
        pos2[axis] = (dir * 24 * (-1)).toString();

        // animation d'attaque
        game.add.tween(actor.sprite)
                .to(pos1, 50, Phaser.Easing.Quadratic.Out, true)
                .onComplete.add(function() { game.add.tween(actor.sprite).to(pos2, 120, Phaser.Easing.Quadratic.Out, true)
                .onComplete.add(function() { player.isMoving = false;}, this);}, this);


//            var color = victim.isPlayer ? null : '#fff';
//
//            HUD.msg(damage.toString(), victim.sprite, 450, color);
//
//            if (victim.isPlayer) {
//                playerHUD.setText('Player life: ' + victim.hp);
//            }

        // si la victime est morte, la supprimer
        if (victim.hp <= 0) {
            victim.sprite.kill();
            delete actorMap[newKey];
            actorList.splice(actorList.indexOf(victim), 1);
            if (victim !== player) {
                if (actorList.length === 1) {
                    // message de victoire
                    var victory = game.add.text(
                            game.world.centerX,
                            game.world.centerY,
                            'Victoire!\nCtrl+r pour recommencer', {
                                fill: '#2e2',
                                align: 'center'
                            }
                    );
                    victory.anchor.setTo(0.5, 0.5);
                }
            }
        }
    } else {
        // supprime la référence de l'ancienne position de l'acteur
        delete actorMap[actor.x + '_' + actor.y];

        // déplace l'acteur
        actor.setXY(actor.x + dir.x, actor.y + dir.y);

        // recrée la référence de position de l'acteur
        actorMap[actor.x + '_' + actor.y] = actor;
    }

    return true;
}

// gestion de l'IA
function aiAct (actor) {
    var directions = [
        {x: -1, y: 0},
        {x: 1, y: 0},
        {x: 0, y: -1},
        {x: 0, y: 1}
    ];

    // permet de trouver quel est le plus cours chemin vers le joueur
    var dx = player.x - actor.x,
            dy = player.y - actor.y;

    directions = directions.map(function (e) {
        return {
            x: e.x,
            y: e.y,
            dist: Math.pow(dx + e.x, 2) + Math.pow(dy + e.y, 2)
        };
    }).sort(function (a, b) {
        return b.dist - a.dist;
    });

    // déplace l'ennemi en direction du joueur
    for (var d = 0, len = directions.length; d < len; d++) {
        if (moveTo(actor, directions[d])) {
            break;
        }
    }

    // si le joueur est mort, affiche un message de fin de partie
    if (player.hp < 1) {
        var gameOver = game.add.text(
                game.world.centerX,
                game.world.centerY, 'Perdu!\nCtrl+r pour retenter', {fill: '#e22', align: 'center'});
        gameOver.anchor.setTo(0.5, 0.5);
    }
}

// tour du joueur
function playerTurn(event) {
    // si le joueur est en train de se déplacer ou que la direction est bloquée, il ne se passe rien
    // évite les actions multiples
    if (player.isMoving || !Map.canGo(player, event)) { return; }
    moveTo(player, event);

    enemyTurn();
}

function enemyTurn() {
    // fait agit les ennemis
    var enemy;
    // i=1, saute le joueur
    for (var i = 1; i < actorList.length; i++) {
        enemy = actorList[i];
        aiAct(enemy);

    }
}

function skipTurn() {
    // si le joueur est en train de se déplacer ou que la direction est bloquée, il ne se passe rien
    // évite les actions multiples
    if (player.isMoving) { return; }

    enemyTurn();
}



function preload() {
    game.load.spritesheet('dude', 'game/assets/characters.png', 64, 128);
    game.load.tilemap('map' , 'game/assets/deuxieme_test.json', null, Phaser.Tilemap.TILED_JSON);
    game.load.image('tileImage', 'game/assets/terrains.png');
    game.load.json('Calque d\'objet 1', 'game/assets/troisieme_test.json');
}

function create() {

    Map.initMap(Map.tiles);
    depthGroup = game.add.group();
    initActors(this);

    //  Nos contrôles
    cursors = game.input.keyboard.createCursorKeys();
    spaceKey = game.input.keyboard.addKey(Phaser.Keyboard.SPACEBAR);
    upKey = game.input.keyboard.addKey(Phaser.Keyboard.Z);
    downKey = game.input.keyboard.addKey(Phaser.Keyboard.S);
    leftKey = game.input.keyboard.addKey(Phaser.Keyboard.Q);
    rightKey = game.input.keyboard.addKey(Phaser.Keyboard.D);
}

function update() {
    spaceKey.onDown.add(function(){
        skipTurn()});

    leftKey.onDown.add(function(){
        playerTurn({x: -1, y: 0})});

    rightKey.onDown.add(function(){
        playerTurn({x: 1, y: 0})});

    upKey.onDown.add(function(){
        playerTurn({x: 0, y: -1})});

    downKey.onDown.add(function(){
        playerTurn({x: 0, y: 1})});

    cursors.left.onDown.add(function(){
        playerTurn({x: -1, y: 0})});

    cursors.right.onDown.add(function(){
        playerTurn({x: 1, y: 0})});

    cursors.up.onDown.add(function(){
        playerTurn({x: 0, y: -1})});

    cursors.down.onDown.add(function(){
        playerTurn({x: 0, y: 1})});

    // gère la priorité d'affichage des acteurs
    depthGroup.sort('y', Phaser.Group.SORT_ASCENDING);
}