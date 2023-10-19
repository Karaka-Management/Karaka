# Development

## Development environment

 The setup and configuration of the development environment is in the hands of every developer themselves. However, it is recommended to follow the setup instructions in the [Developer-Guide](https://github.com/Karaka-Management/Developer-Guide/blob/develop/general/setup.md).

## Code of conduct

Every organization member and contributor to the organization must follow the [code of conduct](../Policies & Guidelines/Code of conduct.md).

## Code changes

### Topics / Tasks / Todos

Generally, the development philosophy is result orientated. This means that anyone can propose tasks, pick up existing tasks or right away implement their code changes. However, implementing code changes without consulting with a senior developer in advance has a much higher risk of code changes not getting admitted. The easiest way to discuss a code change idea in advance are the github [issues](https://github.com/Karaka-Management/Karaka/issues) or [discussions](https://github.com/Karaka-Management/Karaka/discussions).

Developers  are encouraged to pick open tasks with high priorities according to their own skill level. Senior developers may  directly assign tasks to developers based on their importance. New  developers may find it easier to start with a task that has a low  priority as they often also have a lower difficulty.

Open tasks can be found in the project overview: [PROJECT.md](https://github.com/orgs/Karaka-Management/projects/10)

Tasks  currently in development are prefixed in the priority column with an  asterisk `*` and a name tag in the task description of the developer who is working on the task.

The open  tasks are reviewed once a month by a senior developer. The senior  developer updates the project overview if necessary and requests  feedback regarding development status of important tasks under development. During this process important tasks may also get  directly assigned to developers. This review is performed on a  judgmental bases of the senior basis.

### Code style

Code changes must follow the [style guidelines](https://github.com/Karaka-Management/Developer-Guide/tree/develop/standards). Additionally, the automatic code style inspection tools must return no  errors, failures or warnings. Developers should test their changes with  inspection tools and configurations mentioned in the [inspection documentation](https://github.com/Karaka-Management/Developer-Guide/blob/develop/quality/inspections.md) in advance before submitting them for review.

In rare  cases errors, failures or warnings during the automatic inspection are  acceptable. Reasons can be changes in the programming language, special  cases which cannot, are difficult or must be individually configured in the inspection settings. If this is the case for a code change and if inspection configuration changes are necessary are decided by the senior developer performing the code review.

Automated checks which are run during the review process:

```sh
php ./vendor/bin/phpcs --severity=1 ./ --standard="Build/Config/phpcs.xml"
npx eslint ./ -c ./Build/Config/.eslintrc.json
```

### Tests

Code changes must follow the inspection guidelines (i.e. code coverage) mentioned in the [inspection documentation](https://github.com/Karaka-Management/Developer-Guide/blob/develop/quality/inspections.md). Developers should check if the code changes comply with the inspection guidelines before submitting them.

In rare cases it might be not  possible to follow the inspection guidelines. In such cases the senior  developer performing the code review may decide if the code change still gets accepted.

Automated tests which are run during the review process:

```sh
php ./vendor/bin/phpunit -c tests/PHPUnit/phpunit_default.xml
php ./vendor/bin/phpstan analyse --autoload-file=phpOMS/Autoloader.php -l 9 -c Build/Config/phpstan.neon ./
npx jasmine-node ./
./cOMS/tests/test.sh
```

Additional inspections which are run but might be ignored during the review depending on the use case are mentioned in the [inspection documentation](https://github.com/Karaka-Management/Developer-Guide/blob/develop/quality/inspections.md) as other checks.

### Demo

Some code changes may also require changes or  extensions in the demo setup scripts. The demo setup script try to  simulate a real world use case by generating and modifying mostly random data. This is also a good way to setup and “manually” test the code changes in a larger picture. The  demo setup script can be found in the [demoSetup](https://github.com/Karaka-Management/demoSetup) repository. The demo setup script takes a long time due to the large amount of user input simulated data which is generated. Therefore it is  recommended to run this only sporadically.

### Code review

In addition to the automatic code review performed by the various inspection tools such as (phpcs, phpstan, phpunit, eslint and custom scripts) a senior developer must check the proposed code change before it is merged with the respective `develop` branch. Only upon the approval by the reviewer a code change requests gets merged as no other developers have permission in the software to make such code merges.

In case a code change request is not approved the reviewer states the reason for the decision, this may include some tips and requests which will allow the contributor to make improvements so that the code change may get approved.

If the code reviewer only finds minor issues with the proposed code change the reviewer may make small changes to the proposed code change and inform the contributor to speed up the implementation process. Code reviewers are encouraged to do this with new contributors to avoid long iteration processes and to not discourage new developers. However, communication is key and severe issues with code change requests or if the contributor already made multiple code change requests in the past the reviewer should not implement the improvements by himself and rather decline the code change requests with his reasoning.

### Release flow

Code changes must be performed in a new branch. A new branch can be created with:

```sh
git checkout -b new-branch-name
```

The name of the branch can be chosen freely however it is recommended to follow the following branch naming conventions:

* `feature-*` for feature implementations
* `bug-*` for bug fixes
* `security-*` for security related fixes/improvements
* `general-*` for general improvements (i.e. code documentation improvements, code style improvements)

The senior developer who performs the code review merges the change request into the `develop` branch upon approval.