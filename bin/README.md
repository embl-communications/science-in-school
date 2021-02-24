# SiS Wordpress Development Setup

This folder contains scripts used to aid local & live wordpress development of various Wordpress sites & Group microsites using [Visual framework Wordpress Theme](https://git.embl.de/grp-stratcom/vf-wp). This has been [forked from the EMBL-EBI environment](https://gitlab.ebi.ac.uk/ebiwd/wordpress-bin.git) on 2021.02.22 to be specific to the SiS configuration.

## To do

- On 2021.02.22 this was forked, it has a lot of EMBL Group sites configuration that can be pruned

## Usage of development scripts

- `bin/dev <options>` - spin quick/down/logs local development environment
- `bin/dev quick` to build default production wordpress site on local

## Typical workflow for creating a new site

- `rm -rf _*` - to clear existing database and files
- `bin/dev up` - to spin up docker containers for local development
- `bin/dev quick` - to build default production wordpress site on local
- `bin/dev quick_blank` - to build blank wordpress website with Visual Framework plugin  & theme disabled mode
- `bin/dev launch` - to launch browser
- `bin/dev down` - to spin down docker containers
- `bin/dev login` - to login in wordpress admin

## Diagnostics

- `bin/dev logs` - tail logs from containers
- `bin/dev mailhog` - launch mailhog to view mail sent my containers
- `bin/dev pma` - launch phpMyAdmin to view database

## Pre-requisites (OSX)

You will need
- [Docker Community Edition](https://www.docker.com/community-edition#/download) installed on your development machine
