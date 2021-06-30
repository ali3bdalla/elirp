#!/bin/sh

set -e

echo 'running npm install'
npm install

echo 'initialization done, start watching'
npm run prod
