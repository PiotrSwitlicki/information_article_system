jest to zalecane, gdyż może spowodować błędy w aplikacji):

    ```
    composer install --ignore-platform-reqs
    ```

4. Skonfiguruj plik `.env` na podstawie pliku `.env.example`. Ustaw połączenie z bazą danych oraz inne istotne zmienne środowiskowe.
5. Wygeneruj klucz aplikacji Laravel wpisując w konsoli:
    ```
    php artisan key:generate
    ```
   A następnie wklej go w plik .env w pozycji "APP_KEY=" po znaku równości. 

## Użycie projektu
1. Aby uruchomić serwer lokalny, wyszukaj w google, pobierz i zainstaluj XAMPP. Po zainstalowaniu XAMPP kliknij start przy pozycjach Apache i MySQL, ale tylko jeśli nie są zaznaczone kolorem zielonym. Jak są na zielono, to nic nie robimy. Następnie w lokalizacji gdzie zainstalowaliśmy XAMPP - domyślnie "C:\xampp\htdocs" do folderu htdocs kopiujemy folder z wcześniej pobranym i przygotowanym repozytorium. 

   Aplikacja będzie dostępna pod adresem `http://localhost/information_article_system`.

2. Wykonaj migracje, aby utworzyć tabele w bazie danych wpisując w konsoli:
    ```
    php artisan migrate
    ```

3. Przejdź do przeglądarki internetowej i otwórz powyższy adres, aby uzyskać dostęp do aplikacji.

4. Interfejs użytkownika umożliwia dodawanie nowych artykułów oraz edycję istniejących. Możesz również przeglądać artykuły i dodawać autorów. Można także utworzyć nowy artykuł dodając przy tym jednocześnie nowego autora. W tym celu należy kliknąć w menu górnym "Dodaj artykuł", a następnie z listy "Autorzy:" wybrać ostatnią pozycję "Dodaj nowego autora". Można także do artykułu przydzielić kilku autorów przytrzymując przyciśnięty przycisk myszy i przeciągając lub przytrzymując klawisz ctrl i klikając na odpowiednie pozycje z listy. 

5. Można wykonać seedy z danymi z fakera do bazy danych 
   php artisan db:seed --class=AuthorSeeder
   php artisan db:seed --class=ArticleSeeder
   php artisan db:seed --class=ArticleAuthorSeeder

6. Endpointy API do przetestowania np. w Postmanie albo po prostu do wstawienia w pasek adresu przeglądarki. Zamiast nawiasów klamrowych z ich zawartością należy wpisać liczbę. 
Najlepsi autorzy:
http://localhost/information_article_system/public/top-authors
Do pobierania wszystkich artykułów danego autora:
http://localhost/information_article_system/public/articles/API/{authorId}
Do pobierania artykułu według identyfikatora
http://localhost/information_article_system/public/article/{id}

7. Testy. Przygotowane zostały metody testujące endpointy API. Aby je wywołać, użyj polecenia:

    ```
     php artisan test
    ```
8. Routingi w aplikacji zostały podzielone na dwie grupy. 

## Kontakt
W przypadku jakichkolwiek pytań lub problemów, skontaktuj się ze mną pod adresem piotrswitlicki2@gmail.com