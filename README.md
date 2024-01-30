# TD création d'un Micro ORM

## 👨‍🎓 Etudiant
- Nicolas Bernardet
- Clément Oudin

## 💻 Déploiement

Optionnel : Renommer .env.exemple en .env et entrer des valeurs aux variables

```
MARIADB_ROOT_PASSWORD:
MARIADB_DATABASE:
```

Renommer conn.ini.exemple en conn.ini dans /src/ et modifier les valeurs si les valeurs du .env de docker ont été modifié

```
driver=mariadb
host=localhost:3306
database=ormdb
username=root
password=password
```

Lancer les containeurs docker :
```
docker compose up
```

L'initiation de la db SQL s'exécutera automatiquement

## Ports utilisés
🐬 MariaDB -> 3306

⛏ Adminer PHP -> 8080
