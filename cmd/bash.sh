#!/bin/bash
docker-compose -f ../Docker/docker-compose.yml exec workspace bash -c "cd web && \"$@\""