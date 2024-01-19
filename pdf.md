# Markdown to PDF

The standard is to write documents in markdown. To get a correct result we use pandoc to generate a **PDF** file for sharing.

Installation instructions for **Ubuntu**:

```shell
sudo apt install -y pandoc 
sudo apt install -y fonts-dejavu-core
```

Installation instructions for **MacOS**:

```shell
brew install pandoc
brew install font-dejavu
```

[Firing up LaTex on macOS](https://gist.github.com/LucaCappelletti94/920186303d71c85e66e76ff989ea6b62)

Now the PDF files can be generated:

```shell
./pdf.sh markdownfile
```

The generated PDF file can be now used in normal way.
