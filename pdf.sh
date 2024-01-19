#!/bin/bash

# Make HTML by debug option...
#mdpdf informatik-einsteiger.md --debug

# Create the main PDF
pandoc \
    --toc \
    --standalone \
    --listings \
    --number-sections \
    --highlight-style breezedark \
    -f markdown-implicit_figures \
    --from=markdown \
    --pdf-engine=xelatex \
    -V mainfont="DejaVu Sans" \
    -V geometry:a4paper \
    -V geometry:margin=2cm \
    -V toccolor=black \
    -V block-headings:true \
    -H pdf.tex \
    $1.md \
    -o $1.pdf
