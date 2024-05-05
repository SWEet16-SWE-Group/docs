FROM archlinux:base-devel-20240101.0.204074
WORKDIR /validatore/
RUN pacman -Sy --noconfirm --needed \
  php hunspell hunspell-it hunspell-en_us \
  texlive \
  texlive-latex \
  texlive-binextra \
  texlive-latexrecommended \
  texlive-latexextra \
  texlive-langitalian
USER messer:messer
CMD sed -zi 's/\r//g;' $(find . -type f -name '*.bash' -o -name '*.tex' -o -name '*.php' -o -name '*.md') && bash validatore.bash
