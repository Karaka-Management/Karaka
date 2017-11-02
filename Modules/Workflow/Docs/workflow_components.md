# Workflow Components

Every workflow has to provide a set of components in order to work. Other files are optional but can be used in order to enhance the experience. Additional files may be provided for better templating or for additional models but are not a necessety.

## Template

The `template.tpl.php` file contains the UI of the workflow.

## States

A `States.php` file contains all workflow states. This is especially important in order to show different content inside of the `template.tpl.php` depending on the state or in order to trigger state depended actions.

## Workflow

The `Workflow.php` file is the heart of every workflow. This file is responsible for executing state driven actions and it can also be seen as the API for a workflow. All workflow related actions will be forwarded to this file and can be handled inside including database queries.

##