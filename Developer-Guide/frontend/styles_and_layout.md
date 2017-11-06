# Styles and Layout

## Css

This project only supports scss and css. All css files need to be provided with a scss file which will be processed for every build. The css file has to be minimized, optimized and compressed as `.gz`. This means there is at least one scss file (multiple if you are combining/importing multiple scss files and creating one output css file), one css file and one compressed `.gz` file. The file name has to be lower case and the same for every file and only the extension is different.

## Icons

This project uses font-awesome for its icons, the following example allows for stacked icons e.g. creating new/undread email notifications:

```html
<i class="fa fa-lg infoIcon fa-envelope">
    <span class="badge">333</span>
</i>
```

## Examples

An example of all styles can be found in the tests called `StandardElements.htm`.