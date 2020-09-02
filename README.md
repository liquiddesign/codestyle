# Liquid Design - Code style
Používáme coding standard **PSR-2** s oddělovači **tabulátory** a dále některými rozšiřujícími pravidly převzatá ze **Slevomat Code Style**. 
Dodržujume validace nastavené, které umožňuje Inspections v PhpStormu.

![Release](https://img.shields.io/github/v/release/liquiddesign/codestyle.svg?1)

## Naše mise
Sjednotíme kód v rámci týmu, předejmeme chybám, budeme mít kód připravený pro nové členy týmu a přístupný pro externí nástroje

Jako kontroloní mechanismy používáme **Code Sniffer**, **Inspections** a **Code Style** integrované v PHPStormu. Sniffer by měl být také na git commit
ve verzovaném adresáři **.hooks** a případně použitý v CI.

Náš prostředek k dodržení mise je **liquiddesign/codestyle**.

## Tvůj cíl
Mít zelenou fajfku :)

<img src="https://i.imgur.com/ksrNxKb.png" width="600">

## Hlavní pravidla
- oddělovač zanoření je **TAB(4)** a oddělovač řádků \r\n /CRLF/
- soubor končí jedním **prázdným řádkem**
- pojmenování souboru je **PSR-4**, tedy jedna třída, jeden soubor a stejně pojmenovaný ve struktuře reflektující namespace
- délka řádku 200 znaků
- pojmenování identifikátoru je **camelCase**, v případě namespaců a tříd je **CamelCase**
- mapovací property modelu na sloupce databáze @column jsou **snake_case**
- snažíme se psát **anglicky**, komentáře jsou povoleny také v češtině
- klíčová slova **null, true, false** vždy malým
- **yoda** podmínky jsou zakázany
- typové porovnání **===** apod.
- use namespaců musí být řazen **abecedně**
- hlavní části souboru jsou odděleny prázdným řádkem namespace, use a definice třídy
- těla namespaců, tříd, metod, funkcí začínají a končí bez prázdného řádku
- scope (znak "{") **namespaců, tříd, metod, funkcí** začíná na **novém řádku** 
- scope (znak "{") kontrolních statementu jako **if, foreach, while apod** jsou na tom **samém řádku**
- kontrolní statementy musí mít před sebou prázdný řádek
- jednoduché závorky kontrolních statementů mají před závorkou mezeru / **if ()** /
- return a throw má před sebou prázdný řádek
- pole je definováno hranatými závorkami a poslední prvek má vždy za sebou čárku
- **PhpDoc** - je nepovinný, ale vlastnosti musí v případě výskytu PphDoc @var a metody @return. Je hlídán kompaktní formát.
- **nepoužité** namespace, třídy, metody, funkce, vlastnosti a proměnné jsou zakázány
- **silná typovost** je vyžadována u parametrů metod, návratových typů, včetně null operatoru "?". U mixed návrtatových typů použijte doc komentář s "|".
- neznámé metody objektů jsou hlídané a pokud je volané něco dynamického je nutné definovat @var
- každá metoda bude ošetřena na try catch nebo bude mít v PhpDoc **@throw** případně @expectedException
- oddělovač adresářu musí být nezávislí na platformě, tedy konstantou DIRECTORY_SEPARATOR 
- ve třídě jsou nejdříve public metody a poté private metody

## Instalace Code Snifferu a LQD Code Style
```
composer create-project liquiddesign/codestyle
```
Instalace spustí následující:
```
git config --global core.hooksPath .hooks
```

- Code sniffer je součástí projektu **codestyle**, stačí si ho tedy clone a spustit composer install
- pak jednoduše lze spustit /codestyle/vendor/bin/phpcs.bat --standard=<STANDART OR RULESET.XML> <FILE OR PATH>
- náš codestyle je v rootu projektu jako soubor ruleset.xml
- více info o snifferu zde: https://github.com/squizlabs/PHP_CodeSniffer/wiki/Usage
- vice info o slevomat cs: https://github.com/slevomat/coding-standard

## Spoštění přes příkazovou řádku
```
vendor/bin/phpcs --standard=ruleset.xml src
```

## Nastavení PhpStormu

#### 1. Import pravidel Inspections a Code Style
1) V menu "File" dejte "Import Settings"


#### 2. Konfigurace Code Sniffer

**1) Zadání cesty Code Snifferu**

zadejte ve vyhledání v settings "code sniffer"  a následně zadejte cestu /codestyle/vendor/bin/phpcs.bat

<img src="https://i.imgur.com/4HMTJx5.png" width="600">

**2) Propojení automatické live validace**  

TENTO KROK MŮŽETE VYNECHAT POKUD JSTE IMPORTOVALI NASTAVENÍ

zadejte ve vyhledání v settings "inspection code sniffer", povolte live validaci a načtěte vlastni coding standart /codestyle/ruleset.xml

<img src="https://i.imgur.com/AhH2d1f.png" width="600">

## Nastavení Gitu

Hooky v projektech sdílíme ve složce: .hooks

## Reformátování exitujícího kódu a kontrola z příkazové řádky

- pro automatický reformat slouží program phpcbf.bat. Má stejné parametry jako phpcs.
- pro reformat označeného kodu v PhpStormu stiskněte CTRL+ALT+L

## Řešení nestandartních situací

#### Overriduji metodu z vendoru, která nemá strict types
Jednoduse ji popisu jako mixed
```php
/**
 * 
 * @param mixed $max
 */
public function createProgressBar($max = 0): ProgressBar
{
```
nebo můžu potlačit vyloženě vybrané pravidlo

```php
@phpcsSuppress SlevomatCodingStandard.TypeHints.TypeHintDeclaration.MissingParameterTypeHint
```
#### Narazím na bug, který mi neustále vzhazuje phpcs chyby
Konzultuji s Oldrichem a případně dám line ignorovat pomocí @codingStandardsIgnoreLine
```php
use TranslatorPresenterTrait { // @codingStandardsIgnoreLine
        TranslatorPresenterTrait::startup as protected translatorStartup;
        TranslatorPresenterTrait::beforeRender as protected translatorBeforeRender;
}
```

```
#### Iteruji nad kolekcí objektů třídy, která není v kódu určena
Doplním typ před iterační statement
```php
/* @var $objs Test[] */
foreach ($objs as $obj) {
$obj->test(10);  // zde bych dostal error o neznáme metodě a nevalidoval by se mi typ parametru
```
#### Přistupuji k neznáme metodě objektu, který není explicitně určen
Doplním typ před proměnnou nebo zvážím jiný přístup (@inject)
```php
/** @var \Nette\Caching\IStorage $storage */
$storage = $this->context->getByType();
$storage->write(10); // zde bych dostal error o neznáme metodě a nevalidoval by se mi typ parametru

/** @var \Nette\Forms\Controls\BaseControl[]|\App\Admin\Control\Form $form */
$form = $this->getForm();

/**
 * @param int|string $name
 * @return \Nette\Forms\Container|\App\Admin\Control\FormContainer
 */
public function addContainer($name): \Nette\Forms\Container

/**
	 * @var \Nette\Http\SessionSection|\StdClass
	 */
	public $sessionSubcart;

Template

pretezovani getForm()

/**
	 * @param bool $throw
	 * @return \Nette\Forms\Form|\App\Admin\Control\Form|null
	 */
	public function getForm(bool $throw = true): ?\App\Admin\Control\Form
	{
		return parent::getForm($throw);
	}
```
ArrayHash u formu
$values

Cart Manager 325

$bankAccountNumberInput --> radher than $for[bankAccountNumberInput]

@phpstan-ignore-next-line
@noispection

RETURN TYPES
https://stackoverflow.com/questions/42649694/can-i-tell-phpstorm-what-the-return-type-of-a-function-is-going-to-be

#### Potřebuju použít klíče pole a ne hodnoty. Codestyle mi řve o nevyužití $value
```php
foreach (\array_keys($users) as $value) {

}
```

FIXING auto "phpcsfix": "phpcbf --standard=ruleset.xml app"

#### Píšu testy a využívám anotaci @throws
Použijte @expectedException


#### Mám nachystaný kód a code sniffer mi hlásí, že příliž zanořuji, ale potřebuju to z určitého důvodu mít
Tato anti-nestovací funkce je užitečná, ale můžeme použít pěkný workaround
```php
foreach ($users as $user) {
    if ($neco) {
    
    } 
    
    continue; // prevent anti-nesting
}
```
### Povolené vyjímky
Language & Frameworks -> PHP -> Anaylis

\Nette\Application\AbortException
\Nette\Application\BadRequestException
\Nette\Application\UI\InvalidLinkException
\Error
\LogicException
\RuntimeException

### Mixed a UNION types
/**
 * @param int|float $number
 * @param \App\Eshop\DB\Currency|null $currency
 */
public function __invoke($number, ?Currency $currency = null): string

### Mixin
Používejte Doc comment @mixin u trait.

### Generika
U repozitářů používejte @extends


### Doplňování a zodpovědnost
Pokud budete chtít změnit pravidla nebo konzultovat chybu přijdte za Oldřichem

## Pojmenování souborů, adresářů a struktura

- adresáře s malým počátečním písmenem nejsou PSR-4 autoinclude friendly a vice versa
- adresáře s podtržítkem jako prvním znakem jsou speciální, jednorázové adresáře
- názvy projektových souborů jsou CamelCase
- datové soubory, ridici /git/ jsou pojmenovány snake_case
- soubory s interface zacinaji na I
- soubory s trait končí Trait
- vyjímky mají příponu Exception
- factory, DI, repository, tracy a jiné implementující nějaký pattern mají pattern jako suffix s velkým počátečním písmenem např. CartFactory


### Příklad aplikace
* .hooks
* _sql
* app
	- configs
    - modules
    	- Module
        	- DB
            - Components
            - Scripts
            - templates
            - tests
            ModulePresenter.php
    - Tools
* public
    - css
    - img
    - js
    - fonts
* temp
* userfiles
* vendor
* composer.json
* README.md

### Příklad balíčku
* tests
    - configs
    - _sql
    - DB
    - temp
* tools
* src 
	- Forms
	- Controls
	- assets (css, js)
	- Bridges 
	    templates
		- CustomDI (extensions)
		- CustomTracy (debug panel)
	- templates
	- DB (model, repository, interface)
    - ProductException.php  
    - IProduct.php  (Interface)    
    - TestTrait.php  (Trait)    
    - ProductFactory.php   
* config.neon  
* composer.json
* README.md
