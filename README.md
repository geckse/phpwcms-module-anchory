# Anchory

Anchory is a *phpwcms* module, which delivers enhanced intern linking.

- Adds new "easy-to-use" Replacement-Tags 
- Article-structure selection in CKEditor link dialog
- Automatic delinking deadlinks (new Replacement-Tags only)

For further information check module page: www.geckse.de/anchory.html

## New CKEditor-Link dialog

![Anchory CKEditor](https://github.com/geckse/phpwcms-module-anchory/anchory_eckeditor.png)


## Replacement-Tags

```html
<!-- [LINKHREF ID/Alias] RT: index.php?articlealias -->
<a href="[LINKHREF 23]" title="My awesome link">Link to article with id 23</a>

<!-- [LINK ID/Alias] RT: complete Anchor -->
[LINK 23]
<!-- compiles to: 
    <a href="index.php?articlealias" title="Articlename">Articlename</a>
  -->
```
## Deadlink proof

By using these replacement-tags you beeing safe from deadlinks: when the article to link is unknown (maybe deleted? or inactive?) these replacement-tags will clear the anchor element and leaves the content information.  

```html
    <a href="[LINKHREF deadarticle]">Interessting <strong>Article</strong></a>
    <!-- compiles to: Interessting <strong>Article</strong>
```

## Planed Features

- overview of intern- and outgoing links
- backend-notice in case of dead links

## Compatibility

Developed on phpwcms v1.8 with php 5.3



License
----
GPL (Notice: May change for later versions)
