TestBundle
==========

Paczka usprawnia mechanizm Symfonowskiego ładowania fixturesów. Paczka jest całkowicie autonomiczna, oraz
jest pokryta testami jednostkowymi w 100%. Co więcej, TestBundle wprowadza nową zasadę odwoływania się
do konkretnych elementów na stronie za pomocą tak zwanych uchwytów.

[![Build Status](https://travis-ci.org/n-educatio-pl/TestBundle.png?branch=2.3)](https://travis-ci.org/n-educatio-pl/TestBundle)


Instalacja
----------

Zmiany dla pliku composer.json

``` json
"repositories": [
    {
        "type": "package",
        "package": {
            "name": "n-educatio/testbundle",
            "version": "dev-master",
            "source": {
                "type": "git",
                "url": "git@github.com:n-educatio/TestBundle.git",
                "reference": "master"
            }
        }
    }
],
"require": {
    "n-educatio/testbundle": "dev-master"
},
"autoload": {
    "psr-0": { 
        "Neducatio\\TestBundle": "vendor/n-educatio/testbundle/src"
    }
}
```
    
Następnie instalujemy brakujące vendorsy:

```
php composer.phar install
```

Uruchamianie testów paczki TestBundle
-------------------------------------

Aby uruchomić testy tej paczki, trzeba stworzyć bazę danych (o ile już nie istnieje na devie) zgodną z plikiem **config.yml**. Baza ta musi zawierać pustą tabelę animal, zatem wystarczy wykonać poniższe polecenia:
``` sql
CREATE DATABASE neducatio_testbundle;
CREATE TABLE animal();
```

Następnie można uruchomić testy poleceniem: t phpunit, etc.

Przykład użycia fixturesów
--------------------------
Przykład można zobaczyć [tutaj](https://github.com/n-educatio/TestBundle/tree/master/testapp)
    
Przykład użycia uchwytów
------------------------
**Przykład testu dla zmiany języka:**

Kontekst

``` php
class LanguageContext extends BaseSubContext
{
  /**
   * Change website language
   *
   * @param string $language New langauge
   *
   * @When /^I change language to ([^"]*)$/
   */
  public function changeLanguage($language)
  {
    $this->setPage(LanguagePanel::NAME);
    $this->getPage()->changeLanguage($language);
  }
}
```

W naszym przypadku PageObjectem może stać się każdy element na stronie, taki jak menu, panel językowy, itp. Na co
należy zwrócić uwagę to pole $proofSelector, które informuje o zasięgu działania PageObjectu.

``` php
class LanguagePanel extends BasePageObject
{
  const NAME = __CLASS__;
  protected $proofSelector = '.t_languages';
  /**
   * Changes language
   *
   * @param string $language Language
   */
  public function changeLanguage($language)
  {
    //Nasze uchwyty w tym przypadku to 
    //t_language_polish
    //t_language_english 
    $this->get('language_' . $language)->click();
  }
}
```
    
Zauważ, że metoda get() pobiera teraz uchwyt id, który musi być zahardkodowany w htmlu jako t\_uchwyt.

Podział na Persony/itp
----------------------

Naszym celem jest wczytanie tylko konkrentych Fixturesów potrzebnych do odpalenia testów, stąd każdy
Fixture deklarowany jest jako konkrenta Osoba/Kurs/Komentarz/itd, który posiada unikatowe właściwości i atrybuty.
Powiedzmy, że w naszym systemie istnieje dwóch testowych użytkowników: Julia Lazy ( persona, która jest już
zarejestrowana w serwisie ) oraz Amy Fresh ( persona nie powiązana jeszcze w żaden sposób z aplikacją, ale posiadająca
swój własny adres email, nazwę itp. Tworzymy je w następujący sposób:
Nasza Amy Fresh

``` php
class LoadAmyFreshUserData extends LoadActorUserData
{
  const NAME = __CLASS__;
  protected $order = 100;
  protected $userData = array(
    'AmyFresh' => array(
      "username" => "amy.fresh@example.com",
      "description" => "Teacher that visits the app for the first time and wants to give it a try",
      "roles" => "ROLE_USER",
      "firstname" => "Amy",
      "lastname" => "Fresh",
      "registered" => false,
    ),
  );
}
```

Oraz Julia Lazy

``` php
class LoadJuliaLazyUserData extends LoadActorUserData
{
  const NAME = __CLASS__;
  protected $order = 101;
  protected $userData = array(
    'JuliaLazy' => array(
      "username" => "julia.lazy@example.com",
      "description" => "User that is only registered in the system",
      "roles" => "ROLE_USER",
      "firstname" => "Julia",
      "lastname" => "Lazy",
      "registered" => true,
    ),
  );
}
```

Obie persony w tym przypadku muszą dziedziczyć po klasie [LoadActorUserData](https://github.com/n-educatio/cb/blob/master/src/Neducatio/UserBundle/DataFixtures/ORM/LoadActorUserData.php).
Oczywistym staje się fakt, że każdy rodzaj person będzie miał analogicznie budowaną klasę, po której dziedziczą persony
tego samego rodzaju.

Zależności
----------

###Dodawanie
Przejdżmy teraz do sedna możliwości naszego TestBundle. Załóżmy, że chcemy dodać do naszych Fixturesów pewne zależności.
Robimy to w bardzo prosty sposób. W klasie Fixture A, która jest zależna od klasy Fixture B dodajemy taki oto krótki 
wpis:

``` php
protected $dependentClasses = array(
  B::NAME,
);
```

Teraz za każdym razem, gdy będziemy próbowali wczytać Fixture A, nasz TestBundle doczyta nam zależny Fixture B.

###Wczytywanie
Czas na ostatni krok, jakim jest wczytanie Fixturesów. By móc tego dokonać należy w metodzie kontekstu dodać poniższy
kod:

``` php
public function mojaMetodaKontekstowa()
{
  $this->loadFixtures(array(
    KLASA_Z_MOIM_PORZADANYM_FIXTUREM::NAME
  ));
  // Dalej robie coś tam z Fixturesami 
  // Dla przykładu:
  $this->getReference('mojaReferencja')->jakasMetoda();
}
```
