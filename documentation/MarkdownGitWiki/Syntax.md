# MarkdownGitWiki Syntax

An overview of the adde syntax feature.

## Markdown

* ["Official" Syntax](http://daringfireball.net/projects/markdown/syntax)
* [Extended Syntax](http://michelf.com/projects/php-markdown/extra/)

## Links


Internal

* [[My new Page]]
* [[Page]](Title)

External

* [test](http://link)
* http://link
* [http://link]
* [[http://link]]
* <http://link>

## Labels

| Code | Output |
| -----|------- |
| ```{ {label|Message|info} }``` | {{label|Message|info}} |
| ```{ {label|Message|success} }``` | {{label|Message|success}} |
| ```{ {label|Message|inverse} }``` | {{label|Message|inverse}} |

## Icons

|Code | Output|
|-----|-------|
| ```{ {icon|beakermenu} }``` | {{icon|beakermenu}}|

## Code

### Inline

hallo ```echo``` hier

### Fenced

* [[/Fenced Code Example]]
