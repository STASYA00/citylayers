# Quickstart: CityLayers API

A few examples on how to work with CityLayers API for the frontend developers.


## Getting categories

On top of the file:

```php
@php use \App\Http\Controllers\GlobalController; @endphp
@php  $categories = GlobalController::categories();@endphp

```

Javascript part:

```js
const categoryInput = {!! json_encode($categories) !!};
/*
categoryInput is an Array of categories. A Category object has the following attributes:
    * id (e.g. 67 - this category id, unique identifier)
    * name (e.g. "Beauty")
    * description (e.g. "Urban beauty is represented by ..")
    * color (e.g. "FF87FF")
*/

```

An example of getting category attributes:

```js
let categories = categoryInput.map(c => c.id); // category ids
let categories = categoryInput.map(c => c.name);  // category names

```

## Getting subcategories

On top of the file:

```php
@php use \App\Http\Controllers\GlobalController; @endphp
@php  $categories = GlobalController::subcategories();@endphp

```

Javascript part:

```js
const subcategoryInput = {!! json_encode($subcategories) !!};
/*
subcategoryInput is an Array of Subcategories. A Subcategory object has the following attributes:
    * id (e.g. 12 - this subcategory id, unique identifier)
    * name (e.g. "Landscape")
    * category_id (e.g. "67" , which corresponds to the "Beauty" category)
*/

```

An example of getting subcategory attributes:

```js
let subcats = subcategoryInput.map(c => c.id); // subcategory ids
let subcats = subcategoryInput.map(c => c.name);  // subcategory names

```


## Getting existing places

On top of the file:

```php
@php use \App\Http\Controllers\GlobalController; @endphp
@php  $categories = GlobalController::places();@endphp

```

Javascript part:

```js
const places = {!! json_encode($places) !!};
/*
places is an Array of places. A Place object has the following attributes:
    * id (e.g. 12123123 - this place id, unique identifier)
    * user_id (e.g. 13 - user who first mapped the place in the app)
    * longitude (e.g. 67.098098)
    * latitude (e.g. 7.98734)
*/

```

An example of getting place attributes:

```js
let lats = subcategoryInput.map(c => c.latitude); // subcategory ids
let lngs = subcategoryInput.map(c => c.longitude);  // subcategory names

```

## Registering a new category grade

```js
const data = 0.7; // grade that the place received
const label = 67; // category id, get it by comparing your category with the category ids from the database
const id = "123" // place id

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: 'POST',
    url: "/save-grade",
    data: {
        data: data,
        label: label,
        id: id
            },
});
```

## Registering a new subcategory grade

```js

const category = 67; // category id, get it by comparing your category with the category ids from the database
const subcat = 12; // subcategory id, get it by comparing your subcategory with the subcategory ids from the database
const id = "123" // place id

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: 'POST',
    url: "/save-subgrade",
    data: {
        data: subcat,
        category: category,
        id: id
            },
});
```

## Registering a new place

Before registering a new place, make sure the logic is in place to avoid duplicates.

```js

const lon = 67.098098; // category id, get it by comparing your category with the category ids from the database
const lat = 7.98734; // subcategory id, get it by comparing your subcategory with the subcategory ids from the database
const user_id = "123" // id of the user adding the place to the database

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: 'POST',
    url: "/save-place",
    data: {
        lon: lon,
        lat: lat,
        id: user_id
            },
});
```