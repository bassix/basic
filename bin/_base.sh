#!/bin/sh

export LC_CTYPE=C
export LANG=C

_dir="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
_dirRoot="$(dirname "${_dir}")"
_dirBackup="${_dirRoot}/backup"
_dirFixtures="${_dirRoot}/db/fixtures"

_slug="${_dirRoot##*/}"
_domain="${_slug}.lan"
