# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Static website for SHARIFA (Школа Корана SHARIFA) - a Quran school network in Makhachkala and Kaspiysk, Russia. The site is deployed at https://sharifa.ru/.

## Tech Stack

- **Static HTML** - No build system, plain HTML files
- **Tailwind CSS** - Pre-compiled CSS in `css/style.css` (v3.4.19)
- **Google Fonts** - Manrope font family, Material Symbols icons
- **Analytics** - Yandex.Metrika integration

## File Structure

- `index.html` - Main landing page
- `branches.html` - Branch locations page
- `branch.html` - Individual branch detail page
- `online.html` - Online learning page
- `contacts.html` - Contact information page
- `admin.html` - Admin page
- `css/style.css` - Tailwind compiled styles
- `images/` - Logo assets (PNG, SVG)
- `photos/` - Branch photos organized by location (akushinskogo, gamidova, reduktorny)
- `documents/` - PDF documents (metodichka)

## Development

No build step required. Edit HTML files directly and preview in browser.

To modify Tailwind styles, the `css/style.css` is pre-compiled. For new utility classes, use inline `<style>` blocks in HTML or regenerate the Tailwind CSS.

## SEO & Metadata

- JSON-LD structured data for EducationalOrganization schema
- Open Graph and Twitter Card meta tags
- Yandex verification and sitemap.xml for search indexing
- Russian language content (`lang="ru"`)

## Design System

Custom color tokens defined in Tailwind config:
- `primary` - #324c69 (dark blue-gray)
- `accent-blue` - #cedbea (light blue accent)
- `background-dark` - #111821
- `background-light` - #f5fcfe
- `text-main` - #0e131b
- `text-muted` - #506d95
