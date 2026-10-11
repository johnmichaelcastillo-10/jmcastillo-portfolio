#!/usr/bin/env bash
# Linux/macOS twin of Deploy.cmd: publish the local WordPress site to Vercel.
exec "$(dirname "$0")/scripts/publish.sh" --deploy
