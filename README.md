# Eezy Recruit Wordpress Plugin

## About
Eezy Recruit pulls open positions from your recruitment platform and renders them via the shortcode in a simple beautiful accordion list.

Available APIs:

- Hire by Google: https://support.google.com/hire/answer/7343009?hl=en
- Personio: https://developer.personio.de/docs/retrieving-open-job-positions

## Installation
Activate the plugin and make changes on the Eezy Recruit settings page

## Setup
1. Go to the Eezy Recruit settings page
2. Select a Platform
3. Set the recruitment ID (see documentation & help info)

## Basic usage
```
[recruit]
```
## Optional
You only need the simple shortcode if you have set up details on the Settings page, never the less you can also specify things in the shortcoe too:
```
[recruit user="myuserid"]
[recruit user="myuserid" platform="Hire by Google"]
```
You can override the text of the 3 table headers (Position/Department/Location) and the button text (Apply now).

## What's next?
If people are interested in that plugin we can:

a) Create a filter for additional APIs
b) Add a custom recruitment post type