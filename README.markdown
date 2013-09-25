TestBundle
==========

Paczka usprawnia mechanizm Symfonowskiego ładowania fixture'sów. Paczka jest całkowicie autonomiczna
i testowanie jej powinno być bezproblemowe. Co więcej TestBundle wprowadza nową zasadę odwoływania się
do konkretnych elementów na stronie za pomocą tak zwanych uchwytów.

Instalacja
----------

Zmiany dla pliku composer.json

    "require": {
        "n-educatio/testbundle": "dev-master"
    }
    "autoload": {
        "psr-0": { 
          "Neducatio\\TestBundle": "vendor/n-educatio/testbundle/src"
        }
    }
    
Następnie instalujemy brakujące vendorsy:

    php composer.phar install
    
Przykłady użycia
----------------
**Przykład testu dla zmiany języka:**

Kontekst

    use Neducatio\TestBundle\Features\Context\BaseSubContext;
    use Neducatio\CommonBundle\Features\PageObject\LanguagePanel;
    class LanguageContext extends BaseSubContext
    {
      private $languages = array(
        'polish'  => 'pl',
        'english' => 'en',
      );
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

W naszym przypadku PageObjectem może stać się każdy element na stronie, taki jak menu, panel językowy.

    use Neducatio\TestBundle\PageObject\BasePageObject;
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
    
Zauważ, że metoda get() pobiera teraz uchwyt id, który tym przypadku musi być zahardkodowany w htmlu
jako t\_uchwyt.
