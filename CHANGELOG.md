# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

Here we write upgrading notes.
 
### Added
 
### Changed
 
### Fixed


## [0.0.2] - 2022-04-25

GitHub metadata

### Added
- .github folder metadata
  - ISSUE_TEMPLATE
    - but_report.md - Don't send bug reports
    - feature_request.md - Don't request features
  - AUTHORS.md
  - CODEOWNERS - who to notify of a PR
  - CONTRIBUTING.md
  - CONTRIBUTORS.md
  - FUNDING.yml
  - pull_request_template.md
  - SECURITY.md
  - SUPPORT.md
- CHANGELOG.md - a standardized open source project CHANGELOG
- CITATION.ccf
- Jekyll
  - _.config.yml
- LICENSE

## [0.0.1] - 2022-04-22

Initial commit

### Added
- General project files
  - README.md - Project information
  - .gitignore - Ignore these files
- Basic lamp stack file structure
  - config/ - configuration data
    - config.php - database connection info
  - html/ - PHP files
    - index.php - home page
    - info.php - phpinfo()
    - styles.css - basic stylesheet
  - seed/ database init data
    - test.csv - test table
  - sql/ - database init scripts
    - 01-create-tables.sql
    - 02-load-sample-data.sql
- Docker support files
  - Dockerfile - build instructions
  - docker-compose.yml - sevices definition
  - docker-compose.override.yml - development environment overrides
  - .env - docker-compose env-file

[Unreleased]: https://github.com/olivierlacan/keep-a-changelog/compare/v0.0.2...HEAD
[0.0.2]: https://github.com/chigeekgreg/lampstack/compare/v0.0.1...v0.0.2
[0.0.1]: https://github.com/chigeekgreg/lampstack/releases/tag/v0.0.1