Cześć. Napisana przeze mnie pozwala na konwersję XML (pliku lokalnego, ftp lub api) do bazy SQLite
lub pliku lokalnego CSV. Wiem, że program nie jest idealny. Troszkę za dużo czasu spłynęło mi 
na Docker'a, ponieważ nie używałem go dotychczas w pracy. 

**Setup:**
docker build -t xml .

docker run -t -d --net=host xml

sprawdzamy docker ps nazwe kontera

docker exec -it nazwa_kontenera php application.php


**W przypadku używania bez dockera:**

stworzyć baze:
sqlite3 ./database/sqlite_database.db

uruchomić composera:
composer install

**Przykładowe komendy:**

php application.php import-xml -o ftp -d csv --filename_output testowyplik -i item -f coffee_feed.xml