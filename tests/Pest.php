<?php

use Tests\TestCase; // Make sure this is imported

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The tests that extend PHPUnit\Framework\TestCase are by default not
| bootstrapped with the Laravel application. You can leverage the
| `uses()` function to bind a TestCase to a directory.
|
*/

uses(TestCase::class)->in('Feature'); // Add this line or ensure it's correct

// If you also have Unit tests that need Laravel features (less common for true unit tests)
uses(TestCase::class)->in('Unit');

// Or for all tests:
// uses(TestCase::class)->in(__DIR__); // This will apply TestCase to all tests in the tests directory

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain
| conditions. The `expect()` function gives you a fluent API for these
| assertions. You can even extend it with your own custom expectations.
|
*/

// ... (rest of your Pest.php file)
