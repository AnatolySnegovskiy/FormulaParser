# Furmula Parser

Parses formulas, with the possibility of a deferred solution with substitution of user variables

composer require carriongrow/formula_parser

## Installation
```bash
$ composer require carriongrow/formula_parser
```
## Description
Supported functions 
basic = '*', '/', '+', '-', '^'
functional operations = 'cos', 'sin', 'exp', 'abs', 'log', 'sqrt', 'tan', 'pi'

cos sin tan - Do not require a transfer from degrees to the radian equivalent 

Available symbols for dynamic variables: 0-9 a-z _ .or [a-z\.0-9\_]
no dependence on the register!

## Example

```php 
 $parser = new FormulaParser();
 $parser->setFormula('test1 * test2 * 2 (1 + 10) / 20'); // Parsing formulas once
 $counter = 1000;
 $result = [];
 while ($counter != 0) { // We use it as many times as we need
   $first = rand(1, getrandmax()) / getrandmax();
   $second = rand(1, getrandmax()) / getrandmax();
   $parser->setVariables(['test1' => $first, 'test2' => $second]); // Replacing user variables with values
   $result[] = $parser->calculate();
   $counter--;
 }
```
more look in tests - https://github.com/AnatolySnegovskiy/FormulaParser/blob/master/test/FormulaParserTest.php
