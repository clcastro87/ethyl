# AGENTS.md

This file contains technical details, build steps, testing instructions, and conventions for AI coding agents working with the Ethyl ETL pipeline library.

## MANDATORY: Always Use Docker

> **Agents MUST run every command inside the Docker container. Never run PHP, Composer, PHPUnit, or php-cs-fixer directly on the host.**

The host machine may not have the correct PHP version or required extensions (`pdo_sqlite`, `simplexml`, etc.). The container is the single source of truth for the toolchain: PHP 8.1, Composer, SQLite, and all extensions.

Rules:

- **Always** prefix commands with `docker compose exec ethyl` (for example `docker compose exec ethyl composer test`).
- If the container is not running, start it first with `docker compose up -d`. Do not fall back to host PHP.
- Do not run `php`, `composer`, `vendor/bin/phpunit`, or `tools/php-cs-fixer/vendor/bin/php-cs-fixer` on the host, even if they happen to be installed.
- Do not "just quickly" run a host command to check something. Start the container instead.
- File paths are shared through the bind mount (`.:/app`), so edits made on the host are immediately visible inside the container at `/app`. There is no need to copy files in or out.
- `docker compose down` when finished is optional; leaving the container running is fine.

Quick reference:

```bash
# Start the environment (once per session)
docker compose up -d

# Install dependencies
docker compose exec ethyl composer install

# Run the test suite
docker compose exec ethyl composer test

# Fix code style
docker compose exec ethyl composer csfix

# Run an arbitrary command in the container
docker compose exec ethyl <command>
```

If `docker compose` (v2) is unavailable, use the legacy `docker-compose` binary with the same arguments.

## MANDATORY: All Tests Must Pass

> **A task is never complete until the full test suite passes. All 119 tests and 146 assertions must be green, with 100% coverage of `src/`.**

Definition of Done for any code change:

1. `docker compose exec ethyl composer test` exits with `OK (119 tests, ...)` and the whole suite passes.
2. `docker compose exec ethyl composer csfix` has been run and leaves no files fixable (verify with `--dry-run` if unsure).
3. `docker compose exec ethyl composer coverage` reports **100%** classes, methods and lines.
4. The exact commands run and their final result are reported back to the user.

Rules:

- **Never** finish a task, hand back code, or open a PR with a failing or skipped test.
- **Never** silence a failure. Do not delete tests, skip them (`markTestSkipped`, `--exclude-group`), weaken assertions, or add `@group`/`--filter` exclusions just to get a green run.
- If a test fails, treat it as in-scope and fix the cause (production code or test) before reporting completion.
- If a failure is genuinely pre-existing and unrelated, verify it is pre-existing (for example with `git stash`), fix it or report it explicitly with evidence — do not ignore it silently.
- Run the **full** suite, not just the files you touched. Pipeline stages are composed, so unrelated agents can break from a shared change.
- Re-run the suite **after** any style fix or refactor, since those can change behavior.
- New code must ship with tests. Adding a feature or agent without a corresponding test does not count as done.

## MANDATORY: Coverage Must Stay at 100%

`src/` is at **100% classes / 100% methods / 100% lines** (322/322). Keep it there.

```bash
docker compose exec ethyl composer coverage
```

Rules:

- Every new class, method and line in `src/` needs at least one test that executes it.
- Do not drop coverage to land a change. If you add code, add the test in the same change.
- Prefer a real test over `@codeCoverageIgnore`. Use the annotation **only** for genuinely unreachable defensive code (extension-provided behaviour, platform guards) and always add a comment saying why it is unreachable. Never annotate code that a test could reach.
- Coverage runs through `phpdbg` (bundled in the container), so no extra extension is needed. Do not add Xdebug or pcov just for coverage.

## Security Audits

There are **two** Composer projects and both must audit clean:

```bash
docker compose exec ethyl composer audit
docker compose exec ethyl composer audit --working-dir=tools/php-cs-fixer
```

`tools/php-cs-fixer` has its own `composer.lock`, so a clean audit of the library does not imply a clean audit of the tooling. When an advisory only affects the tooling, fix it with `composer update <package> --working-dir=tools/php-cs-fixer` and commit the updated lock, then re-run `csfix` to confirm the tool still works. A new advisory is a reason to stop and report, not to ignore.

## How to Work in This Repo (Agentic Workflow)

Short loop that keeps you honest:

1. **Orient** — read the relevant `src/` class and its mirrored test in `tests/` before editing.
2. **Change** — make the smallest edit that satisfies the request, matching surrounding style.
3. **Verify** — run the suite in Docker (see above). Add or update tests alongside the change.
4. **Format** — run `csfix`, then re-run the suite.
5. **Report** — state what changed, the command you ran, and the exact test result.

Handy commands:

| Goal | Command |
| --- | --- |
| Start environment | `docker compose up -d` |
| Install deps | `docker compose exec ethyl composer install` |
| Full test suite | `docker compose exec ethyl composer test` |
| Coverage report | `docker compose exec ethyl composer coverage` |
| Security audit | `docker compose exec ethyl composer audit` |
| Tooling audit | `docker compose exec ethyl composer audit --working-dir=tools/php-cs-fixer` |
| One test file | `docker compose exec ethyl vendor/bin/phpunit tests/Core/StageTest.php` |
| Fix style | `docker compose exec ethyl composer csfix` |
| Check style only | `docker compose exec ethyl tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src --dry-run` |
| Shell in container | `docker compose exec ethyl bash` |

Baseline at time of writing: **119 tests, 146 assertions, 100% coverage** (45/45 classes, 101/101 methods, 322/322 lines) under PHPUnit 9.6.34 (PHP 8.1 in the container's `php:8.1-cli` image), measured with `phpdbg`. Update these numbers when tests are added.

## Project Overview

**Ethyl** is an ETL (Extract, Transform, Load) pipeline library for PHP that provides a modular, composable approach to data processing. The library uses a pipeline pattern where data flows through stages: Input → Transforms → Output.

## Build & Setup

### Prerequisites

- Docker (with Compose). Everything else is provided by the container.
- Inside the container: PHP 8.1+, Composer, and the extensions declared in `composer.json`:
  - `ext-json`
  - `ext-pdo`
  - `ext-simplexml`
  - `ext-libxml`

### Docker Development Setup (Required)

All work happens in the `ethyl` service defined by `docker-compose.yml` (built from `Dockerfile`: `php:8.1-cli` with `pdo`, `pdo_sqlite`, Composer, and SQLite dev libraries; the repo is bind-mounted at `/app`).

1. **Build and start the container:**

   ```bash
   docker compose up -d
   ```

2. **Install dependencies (inside container):**

   ```bash
   docker compose exec ethyl composer install
   ```

   *This takes a moment. Verify it finished by checking that `vendor/` exists.*

3. **Run tests:**

   ```bash
   docker compose exec ethyl composer test
   ```

4. **Stop the environment (optional):**

   ```bash
   docker compose down
   ```

### Installation (Local) — Not Allowed for Agents

Installing or running the toolchain on the host is prohibited (see [MANDATORY: Always Use Docker](#mandatory-always-use-docker)). For reference only, `composer install` and `composer install --working-dir=tools/php-cs-fixer` are what the container already runs for you; do not execute them on the host.

### Project Structure

```txt
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
# Run all tests (always inside Docker)
docker compose exec ethyl composer test
# or
docker compose exec ethyl vendor/bin/phpunit

# Run a single test file
docker compose exec ethyl vendor/bin/phpunit tests/Input/CsvFileInputTest.php

# Run with coverage
docker compose exec ethyl composer coverage
# or
docker compose exec ethyl phpdbg -qrr vendor/bin/phpunit --coverage-html coverage
```

### Test Configuration

- **Test Framework:** PHPUnit 9.x
- **Bootstrap:** `vendor/autoload.php`
- **Test Directory:** `tests/`
- **Test Base Class:** `Ethyl\Tests\AbstractTestCase` (extends `PHPUnit\Framework\TestCase`)
- **Coverage:** Includes `src/` directory, reported by `phpdbg` via `composer coverage`; must stay at 100%

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
- `tests/IO/` - Filesystem/IO tests
- `tests/Helper/` - Helper utility tests
- `tests/Pipeline/` - Pipeline, Input and Output wrapper tests

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
# Fix code style (always inside Docker)
docker compose exec ethyl composer csfix

# This runs, inside the container:
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
- `league/flysystem: ^3.35.3` - Filesystem abstraction (v1 is EOL; 3.35.3+ is required for CVE-2026-102601)
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

CI uses a host PHP runner, but this does **not** relax the Docker rule above: local agent commands must still go through `docker compose exec ethyl`.

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

```mermaid
null → Input → Iterator → Transform → Iterator → Transform → Iterator → Output → void
```

The pipeline is **single-use**: once `run()` is called, it cannot be executed again.

### Filesystem Integration (Flysystem 3)

Flysystem v3 is installed (`^3.35.3`). The v1 API (`AdapterInterface`, `League\Flysystem\Adapter\Local`, `FileNotFoundException`) no longer exists. When touching IO/input code, use:

- `League\Flysystem\FilesystemAdapter` as the adapter type-hint (`src/Input/FlySystemInput.php`, `src/IO/Filesystem.php`).
- `League\Flysystem\Local\LocalFilesystemAdapter` for local paths, registered in `src/IO/FilesystemBuilder.php`.
- `League\Flysystem\UnableToReadFile` (not `FileNotFoundException`) for read failures; an unknown driver throws `InvalidArgumentException`.
- `src/IO/Filesystem::readStream()` returns a resource, which is what `StreamInput` expects.

## Development Workflow

### Adding New Components

1. Create class in appropriate `src/` subdirectory
2. Follow PSR-4 namespace structure
3. Implement required interfaces (`StageInterface`, `DebuggableInterface`)
4. Add `declare(strict_types=1);`
5. Write PHPDoc blocks
6. Create corresponding test in `tests/`
7. Run tests (inside Docker): `docker compose exec ethyl composer test`
8. Fix code style (inside Docker): `docker compose exec ethyl composer csfix`

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
- [ ] Tests written and passing (`docker compose exec ethyl composer test`)
- [ ] Coverage still at 100% (`docker compose exec ethyl composer coverage`)
- [ ] Code style fixed (`docker compose exec ethyl composer csfix`)
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

- Ensure the container is running: `docker compose up -d`
- Ensure dependencies are installed inside the container: `docker compose exec ethyl composer install`
- Check the container's PHP version: `docker compose exec ethyl php -v` (requires 8.1+)
- Verify test database files exist in `tests/Resources/` (visible at `/app/tests/Resources` in the container)

### Code Style Issues

- Run `docker compose exec ethyl composer csfix` to auto-fix most issues
- Check `.php-cs-fixer.php` for specific rules
- Ensure `.editorconfig` is respected by your editor

### Autoloading Issues

- Run `docker compose exec ethyl composer dump-autoload` to regenerate the autoloader
- Verify namespace matches directory structure (PSR-4)

## Agent Usage Tips

### Efficient Exploration

- Use `grep`/`glob` or read source files directly to understand class structures before editing.
- Check `composer.json` scripts to see available shortcuts (`test`, `csfix`).
- Remember that container commands run from `/app`, which is the repository root.

### Code Generation

- **Always** run `docker compose exec ethyl composer csfix` after creating or modifying PHP files to ensure PSR compliance.
- When creating new tests, copy the structure from `tests/Core/IteratorStageTest.php` as a template for data providers.
- If you need to debug a pipeline, remember that all stages implement `debug()`. You can call `$stage->debug()` to inspect its configuration.
- Do not commit generated artifacts such as `.php-cs-fixer.cache` or `.phpunit.result.cache` unless the project already tracks them.

### Common Pitfalls

- **Streaming**: Do not use `iterator_to_array()` on large datasets in production code. It defeats the purpose of the pipeline.
- **Strict Types**: Forgot `declare(strict_types=1);`? The linter *will* complain.

## Resources

- **PHPUnit Docs:** <https://phpunit.de/documentation.html>
- **PSR-12:** <https://www.php-fig.org/psr/psr-12/>
- **PSR-4:** <https://www.php-fig.org/psr/psr-4/>
- **League Pipeline:** <https://pipeline.thephpleague.com/>
