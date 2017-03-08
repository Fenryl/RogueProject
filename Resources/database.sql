#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: Niveau
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS niveaux(
  id         int (11) Auto_increment  NOT NULL,
  jsonNiveau Longtext,
  PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS utilisateurs(
  id     int (11) Auto_increment  NOT NULL,
  pseudo Varchar (255),
  mail   Varchar (255),
  mdp    Varchar (255),
  avatar Varchar (255),
  admin  TinyINT,
  PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Commentaire
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS commentaires(
  id              Int (11) Auto_increment  NOT NULL,
  contenu         Text,
  dateCommentaire TimeStamp,
  id_Utilisateur  Int,
  id_News         Int,
  PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: News
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS news(
  id              Int (11) Auto_increment  NOT NULL,
  titre           Varchar (255),
  contenu         Text,
  dateNews        TimeStamp,
  id_Utilisateur  Int,
  PRIMARY KEY (id )
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Sauvegarde
#------------------------------------------------------------

CREATE TABLE IF NOT EXISTS sauvegardes(
  id              int (11) Auto_increment  NOT NULL,
  etatPartie      Varchar (255) NOT NULL,
  jsonPartie      Longtext NOT NULL,
  datePartie      TimeStamp NOT NULL,
  id_Niveau       Int,
  id_Utilisateur Int,
  PRIMARY KEY (id )
)ENGINE=InnoDB;

ALTER TABLE commentaires ADD CONSTRAINT FK_Commentaire_id_Utilisateur FOREIGN KEY (id_Utilisateur) REFERENCES utilisateurs(id);
ALTER TABLE commentaires ADD CONSTRAINT FK_Commentaire_id_News FOREIGN KEY (id_News) REFERENCES news(id);
ALTER TABLE news ADD CONSTRAINT FK_News_id_Utilisateur FOREIGN KEY (id_Utilisateur) REFERENCES utilisateurs(id);
ALTER TABLE sauvegardes ADD CONSTRAINT FK_Sauvegarde_id_Niveau FOREIGN KEY (id_Niveau) REFERENCES niveaux(id);
ALTER TABLE sauvegardes ADD CONSTRAINT FK_Sauvegarde_id_Utilisateur FOREIGN KEY (id_Utilisateur) REFERENCES utilisateurs(id);
