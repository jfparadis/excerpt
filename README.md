#Excerpt - ExpressionEngine Plugin

Version: 1.0.0
Jean-Francois Paradis - http://github.com/skaimauve
Copyright (c) 2012 Jean-Francois Paradis
MIT License - please see LICENSE file included with this distribution
http://github.com/skaimauve/excerpt

##Introduction

This plugin provides a similar functionality to the function the_excerpt() in Wordpress which
allows developers to display a post summary based on the number of words. This implementation
can also display a post summary based on a minimum number of characters (in that case, the
cut will be done at the next word boundary), which works better with languages like Chinese 
for which the concept of words is different. An ellipsis ([...] by default) is added at the
end of the excerpt.

##Setup

Download the "sk_excerpt" folder and upload it to the third party directory of your ExpressionEngine folder.

##Usage:
* {exp:sk_excerpt chars='true'}{content}{/exp:sk_excerpt}   Use the default 200 characters
* {exp:sk_excerpt chars='500'}{content}{/exp:sk_excerpt}    Use 500 characters

* {exp:sk_excerpt words='true'}{content}{/exp:sk_excerpt}   Use the default 50 words
* {exp:sk_excerpt words='55'}{content}{/exp:sk_excerpt}     Use 55 words

* {exp:sk_excerpt words='55' more='...'}{content}{/exp:sk_excerpt}   Also change the ellipsis to '...'

##Changelog

1.0.0 - Initial plugin