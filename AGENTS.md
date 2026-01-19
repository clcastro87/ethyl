# AGENTS.md

This file contains technical details, build steps, testing instructions, and conventions for AI coding agents working with the Ethyl ETL pipeline library.

## Project Overview

**Ethyl** is an ETL (Extract, Transform, Load) pipeline library for PHP that provides a modular, composable approach to data processing. The library uses a pipeline pattern where data flows through stages: Input → Transforms → Output.

## Build & Setup

### Prerequisites

- PHP 8.1 or higher
- Composer
- Required PHP extensions:
  - `ext-json`
  - `ext-pdo`
  - `ext-simplexml`
  - `ext-libxml`

### Docker Development Setup

You can use Docker to run the environment instead of installing PHP locally.

1. **Build and start the container:**

   ```bash
   docker-compose up -d
   ```

2. **Install dependencies (inside container):**

   ```bash
   docker-compose exec ethyl composer install
   ```

   *Note: This might take a moment. You can verify it finished by checking if `vendor/` exists.*

3. **Run tests:**

   ```bash
   docker-compose exec ethyl composer test
   ```

4. **Stop the environment:**

   ```bash
   docker-compose down
   ```

### Installation (Local)

```bash
# Install dependencies
composer install

# Install code style fixer dependencies (for csfix script)
composer install --working-dir=tools/php-cs-fixer
```

### Project Structure

```
ethyl/
├── src/                    # Source code (PSR-4: Ethyl\)
│   ├── Core/              # Core abstractions (Stage, IteratorStage, etc.)
│   ├── Data/              # Database utilities (Db, DbFactory, Query)
│   ├── Filter/            # Filter agents
│   ├── Flow/              # Flow control agents (BatchAggregator, ForEachRun, etc.)
│   ├── Helper/            # Utility classes
│   ├── Input/             # Input agents (CsvFileInput, PdoQueryInput, etc.)
│   ├── IO/                # Filesystem utilities
│   ├── Mapping/           # Mapping agents (ArrayFieldsMapper, etc.)
│   ├── Output/            # Output agents (CsvFileOutput, PdoTableOutput, etc.)
│   ├── Pipeline/          # Pipeline orchestration
│   └── Transform/         # Transform agents
├── tests/                  # Test suite (PSR-4: Ethyl\Tests\)
├── examples/               # Example scripts
├── tools/                  # Development tools (php-cs-fixer)
└── vendor/                 # Composer dependencies
```

## Testing

### Running Tests

```bash
# Run all tests
composer test
# or
vendor/bin/phpunit

# Run with coverage
vendor/bin/phpunit --coverage-html coverage
```

### Test Configuration

- **Test Framework:** PHPUnit 9.x
- **Bootstrap:** `vendor/autoload.php`
- **Test Directory:** `tests/`
- **Test Base Class:** `Ethyl\Tests\AbstractTestCase` (extends `PHPUnit\Framework\TestCase`)
- **Coverage:** Includes `src/` directory

### Test Structure

Tests mirror the source structure:

- `tests/Core/` - Core component tests
- `tests/Input/` - Input agent tests
- `tests/Output/` - Output agent tests
- `tests/Filter/` - Filter agent tests
- `tests/Transform/` - Transform agent tests
- `tests/Mapping/` - Mapping agent tests
- `tests/Flow/` - Flow control tests
- `tests/Data/` - Database utility tests

### Test Resources

Test data files are located in `tests/Resources/`:

- `books.xml` - XML test data
- `Chinook_Sqlite.sql` - SQLite database schema
- `Chinook.db` - SQLite test database
- `Output.db` - Output test database
- `sales.csv` - CSV test data

## Code Style & Conventions

### Standards

- **PSR-12** coding standard
- **PSR-4** autoloading
- **Strict types** required: `declare(strict_types=1);` at top of every PHP file

### Code Style Rules

The project uses PHP-CS-Fixer with specific rules (see `.php-cs-fixer.php`):

**Key Rules:**

- Single quotes for strings
- Short array syntax `[]`
- Aligned binary operators (`=>`, `=`)
- Single-line class definitions
- Trailing commas in multiline arrays
- No extra blank lines
- Hash-style comments (`#` not `//`)

**Formatting:**

- 4 spaces for indentation (not tabs)
- LF line endings
- UTF-8 encoding
- Trim trailing whitespace
- Insert final newline

### Applying Code Style

```bash
# Fix code style
composer csfix

# This runs:
# 1. composer install --working-dir=tools/php-cs-fixer
# 2. tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src
# 3. tools/php-cs-fixer/vendor/bin/php-cs-fixer fix tests
```

### EditorConfig

The project includes `.editorconfig`:

- Line endings: LF
- Charset: UTF-8
- PHP files: 4 space indentation

## Coding Conventions

### Namespace Structure

- **Source:** `Ethyl\{Component}` (e.g., `Ethyl\Input\CsvFileInput`)
- **Tests:** `Ethyl\Tests\{Component}` (e.g., `Ethyl\Tests\Input\CsvFileInputTest`)

### Class Naming

- Classes use PascalCase
- Test classes end with `Test` (e.g., `CsvFileInputTest`)
- Abstract classes prefix with `Abstract` (e.g., `AbstractMapper`, `AbstractOutput`)

### File Structure

Every PHP file must:

1. Start with `<?php` and `declare(strict_types=1);`
2. Include proper namespace
3. Include PHPDoc blocks for classes and methods
4. Use type hints for parameters and return types

### Interface Patterns

- **Stage Interface:** All stages implement `League\Pipeline\StageInterface`
- **Debuggable Interface:** Components implement `Ethyl\Core\DebuggableInterface` with `debug()` method
- **Iterator Pattern:** Many components work with iterators for memory efficiency

### Common Patterns

**Pipeline Pattern:**

```php
$pipeline = new Pipeline();
$pipeline
    ->setInput($input)
    ->setOutput($output)
    ->pipe($transform1)
    ->pipe($transform2)
    ->run();
```

**Stage Invocation:**
Stages are callable via `__invoke()` method, accepting a payload and returning processed data.

**Iterator Processing:**
Most components process data as iterators to handle large datasets efficiently without loading everything into memory.

## Dependencies

### Production Dependencies

- `league/csv: ^9.7` - CSV handling
- `league/flysystem: ^1.1` - Filesystem abstraction
- `league/pipeline: ^1.0` - Pipeline pattern implementation
- `prewk/xml-string-streamer: ^0.13.0` - XML streaming

### Development Dependencies

- `phpunit/phpunit: 9.*` - Testing framework

## CI/CD

### GitHub Actions

The project uses GitHub Actions (`.github/workflows/php.yml`):

- **Trigger:** Push/PR to `master` branch
- **PHP Version:** 8.1
- **Steps:**
  1. Validate `composer.json` and `composer.lock`
  2. Cache Composer packages
  3. Install dependencies
  4. Run test suite (`composer test`)
  5. Run Composer audit (security scan)

## Key Architectural Patterns

### Pipeline Architecture

1. **Input Stage:** Extracts data from source (returns Iterator)
2. **Transform Stages:** Process data items (can be chained)
3. **Output Stage:** Writes processed data to destination

### Stage Types

- **IteratorStage:** Abstract base for iterator-based processing
- **FunctionStage:** Wraps callable functions as stages
- **Custom Stages:** Extend `Stage` or `IteratorStage`

### Data Flow

```
null → Input → Iterator → Transform → Iterator → Transform → Iterator → Output → void
```

The pipeline is **single-use**: once `run()` is called, it cannot be executed again.

## Development Workflow

### Adding New Components

1. Create class in appropriate `src/` subdirectory
2. Follow PSR-4 namespace structure
3. Implement required interfaces (`StageInterface`, `DebuggableInterface`)
4. Add `declare(strict_types=1);`
5. Write PHPDoc blocks
6. Create corresponding test in `tests/`
7. Run tests: `composer test`
8. Fix code style: `composer csfix`

### Creating Tests

1. Extend `Ethyl\Tests\AbstractTestCase`
2. Mirror source directory structure
3. Use descriptive test method names (`testMethodName_Scenario_ExpectedResult`)
4. Place test resources in `tests/Resources/`

### Code Review Checklist

- [ ] `declare(strict_types=1);` present
- [ ] PSR-12 compliant
- [ ] Type hints on all parameters and returns
- [ ] PHPDoc blocks for classes and public methods
- [ ] Tests written and passing
- [ ] Code style fixed (`composer csfix`)
- [ ] No linter errors

## Common Tasks

### Adding a New Input Agent

1. Create class in `src/Input/`
2. Extend `IteratorStage` or implement `StageInterface`
3. Implement `__invoke()` to return an Iterator
4. Add to `src/Input/` directory
5. Create test in `tests/Input/`

### Adding a New Output Agent

1. Create class in `src/Output/`
2. Extend `AbstractOutput` or implement `OutputInterface`
3. Implement output logic
4. Create test in `tests/Output/`

### Adding a New Transform Agent

1. Create class in `src/Transform/`
2. Implement `TransformerInterface`
3. Add transformation logic
4. Create test in `tests/Transform/`

## Important Notes

- **Memory Efficiency:** The library is designed for streaming large datasets. Use iterators, not arrays, for large data.
- **Single Execution:** Pipelines can only be run once. Create a new instance for multiple runs.
- **Error Handling:** Components throw exceptions for invalid inputs or configurations.
- **Debugging:** All components implement `debug()` method for introspection.
- **Type Safety:** Strict types are enforced throughout the codebase.

## Troubleshooting

### Tests Failing

- Ensure all dependencies are installed: `composer install`
- Check PHP version: `php -v` (requires 8.1+)
- Verify test database files exist in `tests/Resources/`

### Code Style Issues

- Run `composer csfix` to auto-fix most issues
- Check `.php-cs-fixer.php` for specific rules
- Ensure `.editorconfig` is respected by your editor

### Autoloading Issues

- Run `composer dump-autoload` to regenerate autoloader
- Verify namespace matches directory structure (PSR-4)

## Agent Usage Tips

### Efficient Exploration

- Use `view_file_outline` on `src/` to understand class structures quickly without reading full content.
- Check `composer.json` scripts to see available shortcuts (e.g., `composer csfix`).

### Code Generation

- **Always** run `composer csfix` after creating or modifying PHP files to ensure PSR compliance.
- When creating new tests, copy the structure from `tests/Core/IteratorStageTest.php` as a template for data providers.
- If you need to debug a pipeline, remember that all stages implement `debug()`. You can call `$stage->debug()` to inspect its configuration.

### Common Pitfalls

- **Streaming**: Do not use `iterator_to_array()` on large datasets in production code. It defeats the purpose of the pipeline.
- **Strict Types**: Forgot `declare(strict_types=1);`? The linter *will* complain.

## Resources

- **PHPUnit Docs:** <https://phpunit.de/documentation.html>
- **PSR-12:** <https://www.php-fig.org/psr/psr-12/>
- **PSR-4:** <https://www.php-fig.org/psr/psr-4/>
- **League Pipeline:** <https://pipeline.thephpleague.com/>
