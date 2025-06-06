![workflow](https://github.com/r1de/KG6WXC-meshmap-webpage/actions/workflows/codeql.yml/badge.svg)
[![License: GPL v3](https://img.shields.io/badge/License-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![HamRadio](https://img.shields.io/badge/HamRadio-Roger!-green.svg)](https://www.arednmesh.org)
[![MattermostChat](https://img.shields.io/badge/Chat-Mattermost-blueviolet.svg)](https://mattermost.kg6wxc.net/mesh/channels/meshmap)  
  
Webpage Frontend for Automated mapping of [AREDN](https://arednmesh.org) Networks.  
Project Github: [https://github.com/r1de/KG6WXC-meshmap-webpage](https://github.com/r1de/KG6WXC-meshmap-webpage)  
  
## REQUIREMENTS
- **webserver** (Apache, Nginx, IIS, etc)
- **https://github.com/r1de/KG6WXC-meshmap** (to create the nodes and links on the map)
  
Example page using live Southern California Network Data:  
https://mapping.kg6wxc.net/meshmap  

## Setup
- **Create or choose a web accessible directory**  
  ie: `/var/www/html/meshmap`
- **Copy/Clone this repo into that directory**  
  ```git clone https://github.com/r1de/KG6WXC-meshmap-webpage .```
- **Set `webpageDataDir` to this "data" directory in the `user-settings.ini` file of the Polling script**  
  ie: webpageDataDir = "/var/www/html/meshmap/data"
