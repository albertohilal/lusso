#!/bin/bash
# Script para commitear y pushear SOLO el plugin resales-online-connector

PLUGIN_PATH="wp-content/plugins/resales-online-connector"

git add $PLUGIN_PATH
git commit -m "${1:-update plugin}"
git push origin feature/ajuste-conector
