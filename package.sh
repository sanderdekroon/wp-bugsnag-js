#!/bin/bash 

mkdir -p releases

# Remove old packages
rm -rf ./releases/front-end-error-monitoring-with-bugsnag ./releases/front-end-error-monitoring-with-bugsnag.zip

# Create an optimized build of the JS app
npm run build:prod > /dev/null

# Copy current dir to tmp
rsync -ua . ./releases/front-end-error-monitoring-with-bugsnag/

# Remove current vendor & node_modules folder (if any) 
# and install the dependencies without dev packages.
cd ./releases/front-end-error-monitoring-with-bugsnag || exit
rm -rf ./vendor/ ./node_modules/
composer install -o --no-dev


# Remove unneeded files in a WordPress plugin
rm -rf ./.git ./composer.json ./composer.lock ./package.sh \
    ./.vscode ./workspace.code-workspace ./bitbucket-pipelines.yml \
    ./.phplint-cache ./.phpunit.result.cache ./.editorconfig ./.eslintignore \
    ./.eslintrc.json ./.gitignore ./phpunit.xml.dist ./psalm.xml ./.babelrc \
    ./package.lock ./assets/src ./assets/stubs ./package.json ./package-lock.json \
    ./releases

cd ../

# Create a zip file from the optimized plugin folder
zip -rq front-end-error-monitoring-with-bugsnag.zip ./front-end-error-monitoring-with-bugsnag
rm -rf ./front-end-error-monitoring-with-bugsnag

echo "Zip completed @ $(pwd)/front-end-error-monitoring-with-bugsnag.zip"
