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
USER 1000:1000
CMD bash validatore-stile.sh
