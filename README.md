#Excerpt - ExpressionEngine Plugin

Version: 1.0.0
Jean-Francois Paradis - https://github.com/skaimauve
Copyright (c) 2012 Jean-Francois Paradis
MIT License - please see LICENSE file included with this distribution
http://github.com/skaimauve/excerpt

##Introduction

This plugin provides a similar functionality to the function the_excerpt() in Wordpress which
allows developers to display a post summary based on the number of words. This implementation
can also display a post summary based on a minimum the number of characters (in that case, the
cut will be done at the next word boundary), which works better with languages like Chinese 
for which the concept of words are different. An ellipsis ([...] by default) is added at the
end of the excerpt.

##Setup

Download the "excerpt" folder and upload it to the third party directory of your ExpressionEngine folder.

##Usage:
{exp:excerpt chars=true}{content}{/exp:excerpt}   Use the default 200 characters
{exp:excerpt chars='500'}{content}{/exp:excerpt}  Use 500 characters

{exp:excerpt words=true}{content}{/exp:excerpt}   Use the default 50 words
{exp:excerpt words='55'}{content}{/exp:excerpt}   Use 55 words

{exp:excerpt words='55' more='...'}{content}{/exp:excerpt}   Also change the ellipsis to '...'

##Changelog

1.0.0 - Initial plugin