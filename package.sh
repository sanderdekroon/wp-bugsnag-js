#!/bin/bash 

mkdir -p releases

# Remove old packages
rm -rf ./releases/bugsnag-js ./releases/bugsnag-js.zip

# Create an optimized build of the JS app
npm run build:prod > /dev/null

# Copy current dir to tmp
rsync -ua . ./releases/bugsnag-js/

# Remove current vendor & node_modules folder (if any) 
# and install the dependencies without dev packages.
cd ./releases/bugsnag-js || exit
rm -rf ./vendor/ ./node_modules/
composer install -o --no-dev


# Remove unneeded files in a WordPress plugin
rm -rf ./.git ./composer.json ./composer.lock ./package.sh \
    ./.vscode ./workspace.code-workspace ./bitbucket-pipelines.yml \
    ./.phplint-cache ./.phpunit.result.cache ./.editorconfig ./.eslintignore \
    ./.eslintrc.json ./.gitignore ./phpunit.xml.dist ./psalm.xml ./.babelrc \
    ./package.lock ./assets/src

cd ../

# Create a zip file from the optimized plugin folder
zip -rq bugsnag-js.zip ./bugsnag-js
rm -rf ./bugsnag-js

echo "Zip completed @ $(pwd)/bugsnag-js.zip"
