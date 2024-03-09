BEGIN TRANSACTION;
CREATE TABLE IF NOT EXISTS "Parties" (
	"idParties"	INTEGER,
	"idJoueur1"	INTEGER NOT NULL,
	"idJoueur2"	INTEGER NOT NULL,
	"plateau"	TEXT NOT NULL,
	"data" 		TEXT NOT NULL,
	"idJoueurGagnant"	INTEGER,
	"idJoueurTour"	INTEGER,
	FOREIGN KEY("idJoueurTour") REFERENCES "Utilisateurs"("idJoueur"),
	FOREIGN KEY("idJoueur2") REFERENCES "Utilisateurs"("idJoueur"),
	FOREIGN KEY("idJoueur1") REFERENCES "Utilisateurs"("idJoueur"),
	FOREIGN KEY("idJoueurGagnant") REFERENCES "Utilisateurs"("idJoueur"),
	PRIMARY KEY("idParties" AUTOINCREMENT)
);
CREATE TABLE IF NOT EXISTS "Utilisateurs" (
	"idJoueur"	INTEGER,
	"pseudo"	TEXT NOT NULL UNIQUE,
	"mdp"	VARCHAR(255) NOT NULL,
	"estAdmin"	INTEGER,
	PRIMARY KEY("idJoueur" AUTOINCREMENT)
);
INSERT INTO "Utilisateurs" VALUES (1,'test','$2y$10$UBTUO.5g8AkEHi/lvJ06JesO3WTObXfLrUCp1pL4eSavGhw/SYBDK',0);
INSERT INTO "Utilisateurs" VALUES (2,'jiji','$2y$10$mfVLDxTeaPhEaqiZpTG4AuHH047o/MxXtv7K05OocWgq22LEltyqi',0);
INSERT INTO "Utilisateurs" VALUES (3,'mohamed','$2y$10$F9FZMltAsGozk0bf9hVoTeHsiWoajONnPG367zlH/xRk8KmA6iPj6',1);
COMMIT;
