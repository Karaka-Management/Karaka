# Styles and Layout

## Css

This project only supports scss and css. All css files need to be provided with a scss file which will be processed for every build. The css file has to be minimized, optimized and compressed as `.gz`. This means there is at least one scss file (multiple if you are combining/importing multiple scss files and creating one output css file), one css file and one compressed `.gz` file. The file name has to be lower case and the same for every file and only the extension is different.

## Grid/Flexbox

Flexboxes are preferred for all content containers.

```html
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-1">
        <section class="box wf-100">...</section>
    </div>
</div>
```

Available sizes are `xs`, `sm`, `md`, `lg` with a grid ranging from `1-12`.

## Sizes

### Container

A container (e.g. section, div, table, etc) can be sized by using `.wf-*` classes. Available sizes for `*` are `100`, `80`, `75`, `66`, `50`, `33`, `25`, `20`.

## Icons

This project uses font-awesome for its icons, the following example allows for stacked icons e.g. creating new/undread email notifications:

```html
<i class="fa fa-lg infoIcon fa-envelope">
    <span class="badge">333</span>
</i>
```

## Colors

Coloring can be added to many elements such as icons, sections etc. Available colors are `lightgreen`, `green`, `darkgreen`, `lightblue`, `blue`, `darkblue`, `lightred`, `red`, `darkred`, `lightyellow`, `yellow`, `lightorange`, `orange`, `white`, `lightgrey`, `grey`, `black`, `lightpurple`, `purple`, `darkpurple`, `lightteal`, `teal`, `darkteal`, `lightpink`, `pink`.

## Form Elements

### Input with button

The following snippet creates a 100% input with a button next to it.

```html
<div class="ipt-wrap">
    <div class="ipt-first"><input type="text" id="iID"></div>
    <div class="ipt-second"><button>Text</button></div>
</div>
```

### Input with dictionary

The following snippet creates a dictionary button (e.g. for opening a popup window to search for accounts/groups etc) right befor an input field.

```html
<span class="input">
    <button type="button"><i class="fa fa-book"></i></button>
    <input type="text">
</span>
```

## Section

A section is a container for information that can and should be grouped together.

```html
<section class="box wf-100">
    <h1>Title</h1>
    <div class="inner">
        ...
    </div>
</section>
```

Additional coloring of sections can be achieved by adding a coloring class.

```html
<section class="box green">
    ...
</section>
```

## Tabs

## Tables

## Lists

## Accordion

## Breadcrumbs

## Badges/Tags

## Examples

An example of all styles can be found in the tests called `StandardElements.htm`.