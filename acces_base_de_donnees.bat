@echo off
echo "BIENVENUE DANS LA BASE DE DONNEES DU SITE POINT JAUNE"
docker exec -it  sitejaune-db-1 bash -c "psql -U estrakio"