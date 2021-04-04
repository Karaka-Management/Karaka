<span class="clickPopup">
    <label for="filterDropdown"><i class="fa fa-download download btn"></i></label>
    <input id="filterDropdown" name="filterDropdown" type="checkbox">
    <div class="popup">
        <input type="text" name="filterText">

        <select name="valueList">
            <option>>
            <option>>=
            <option><=
            <option><
        </select>

        <label class="button cancel" for="filterDropdown">Cancel</label>
        <label class="button cancel" for="filterDropdown">Filter</label>
        <label class="button cancel" for="filterDropdown">Reset</label>
    </div>
</span>

<!--
>10 & <12
>10 | <12

>10 and <12
>10 or <12

=11

11 // finds also 111

also handle date, numerics, text, tags,
-->