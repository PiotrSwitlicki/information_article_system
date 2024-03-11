# Projekt systemu artykułów informacyjnych

## Opis
Projekt ten jest prostym systemem artykułów informacyjnych, który umożliwia dodawanie, edycję oraz przeglądanie artykułów. System wykorzystuje framework Laravel do backendu oraz HTML formularze do interakcji z użytkownikiem.

## Wymagania
Wymagana jest wersja php conajmniej 8.1

## Konfiguracja środowiska dla systemu Windows

1. Aby uruchomić serwer lokalny, wyszukaj w google, pobierz i zainstaluj XAMPP. Po zainstalowaniu XAMPP, otwórz Control Panel, kliknij start przy pozycjach Apache i MySQL, ale tylko jeśli nie są zaznaczone kolorem zielonym. Jak są na zielono, to nic nie robimy. Następnie w lokalizacji gdzie zainstalowaliśmy XAMPP - domyślnie "C:\xampp\htdocs" w folderze htdocs usuwamy wszystkie pliki i robimy miejsce na nasze repozytoria, koniecznie należy je przechowywać tutaj.

2. W XAMPP Control Panel w linii z pozycją Apache, klikamy Config, z menu wybieramy PHP (php.ini), naciskamy na klawiaturze Ctrl+F, wpisujemy zip, zaznaczamy "W dół", klikamy "Znajdź następny" i usuwamy średnik przed pozycją ;extension=zip, jeśli nie ma tej pozycji to ją dodajemy, zapisujemy, wychodzimy. 

3.Jeśli nie masz zainstalowanego composera, to go pobierz z internetu i zainstaluj. Podczas instalacji koniecznie wskaż lokalizację pliku php.exe z poprzednio zainstalowanego XAMPPa. 

4. Jeśli nie masz zainstalowanych narzędzi dla gita "git for Windows", to pobierz je ze strony "https://gitforwindows.org/". Zainstaluj je. Kliknij w folderze, w którym został zainstalowany xampp, w podfolderze htdocs, w lokalizacji - .../xampp/htdocs, w pustym miejscu prawym przyciskiem myszy i wybierz pozycję "Git Bash Here". Następnie w konsoli wpisz:
    ```
    git clone https://github.com/PiotrSwitlicki/information_article_system
    ```
5. Przejdź w eskploratorze do katalogu projektu "information_article_system". Następnie w pustym miejscu, żeby nie trafić w jakiś plik czy folder, kliknąć prawym przyciskiem myszy, przytrzymując jednocześnie klawisz shift i następnie z menu wybrać "Otwórz tutaj okno programu PowerShell".

6. Zainstaluj wszystkie zależności PHP za pomocą Composer wpisując w otwartej wcześniej konsoli i zaktualizuj samego composera do najnowszej wersji:
    ```
    composer self-update
    ```	 
    ```
    composer install 
    ```
Jeśli w powyższym wyjdą niepasujące zależności można też spróbować polecenia (ale nie jest to zalecane, gdyż może spowodować błędy w aplikacji):

    ```
    composer install --ignore-platform-reqs
    ```

7. Skonfiguruj plik `.env` na podstawie pliku `.env.example`. Ustaw połączenie z bazą danych oraz inne istotne zmienne środowiskowe.
Możesz po prostu skopiować plik `.env.example` i zmienić nazwę tej kopji na `.env`. 

8. Wygeneruj klucz aplikacji Laravel wpisując w konsoli:
    ```
    php artisan key:generate
    ```
   A następnie wklej go w plik .env w pozycji "APP_KEY=" po znaku równości. 

9. Wykonaj migracje, aby utworzyć tabele w bazie danych wpisując w konsoli:
    ```
    php artisan migrate
    ```

## Użycie projektu

1. Przejdź do przeglądarki internetowej i otwórz adres `http://localhost/information_article_system`, aby uzyskać dostęp do aplikacji.

2. Interfejs użytkownika umożliwia dodawanie nowych artykułów oraz edycję istniejących. Możesz również przeglądać artykuły i dodawać autorów. Można także utworzyć nowy artykuł dodając przy tym jednocześnie nowego autora. W tym celu należy kliknąć w menu górnym "Dodaj artykuł", a następnie z listy "Autorzy:" wybrać ostatnią pozycję "Dodaj nowego autora". Można także do artykułu przydzielić kilku autorów przytrzymując przyciśnięty przycisk myszy i przeciągając lub przytrzymując klawisz ctrl i klikając na odpowiednie pozycje z listy. 

3. Wykonaj seedy z danymi z fakera do bazy danych 
    ```
   php artisan db:seed --class=AuthorSeeder
    ```
    ```
   php artisan db:seed --class=ArticleSeeder
    ```
    ```
   php artisan db:seed --class=ArticleAuthorSeeder
    ```

4. Endpointy API do przetestowania np. w Postmanie albo po prostu do wstawienia w pasek adresu przeglądarki. Zamiast nawiasów klamrowych z ich zawartością należy wpisać liczbę. 
Najlepsi autorzy:
http://localhost/information_article_system/public/top-authors
Do pobierania wszystkich artykułów danego autora:
http://localhost/information_article_system/public/articles/API/{authorId}
Do pobierania artykułu według identyfikatora
http://localhost/information_article_system/public/article/{id}

5. Testy. Przygotowane zostały testy funkcjonalne dla endpointów API oraz testy jednostkowe dla kontrolera ArticleControler. Aby je wywołać, użyj polecenia:

    ```
     php artisan test
    ```
6. Routingi w aplikacji zostały podzielone na dwie grupy. 

7. W kontrolerze ArticleController zastosowano wzorzec projektowy Dependency Injection i Service Layer, a w AuthorController Dependency Injection. 

8. Pola formularzy są walidowane na wypadek braku wypełnienia, któregoś z nich. Oraz sprawdzane jest czy danego autora nie ma już w bazie danych. 

## Kontakt
W przypadku jakichkolwiek pytań lub problemów, skontaktuj się ze mną pod adresem piotrswitlicki2@gmail.com
