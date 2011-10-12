# fpPaymentTax

## Overview

The tax functional for e-commerce

## Requirements

* [Symfony](http://www.symfony-project.org) 1.4
* fpPaymentPlugin


## Getting Started

"product" table must have fpPaymentTaxable and fpPaymentProduct behaviours

_schema.yml_

    Product:
      actAs:
        fpPaymentProduct: ~
        fpPaymentTaxable: ~
      columns:
        some_other_field: {type: integer, notnull: true}