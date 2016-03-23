```
/**
 * Conky script - PHP Bitcoin ticker (desktop graphic & price change alerter)
 * I've made this script:
 *  - Show exchanges prices at Conky terminal embedd on your desktop(linux)
 *  - Generate an Alert on relevant price changes
 *  - Draw a graphic on desktop to easily see the price change
 * 
* @package php-bitcointicker-cmdline
* @version 1.0
* @category conky
* @author intrd - http://dann.com.br/
* @copyright 2016 intrd
* @license Creative Commons Attribution-ShareAlike 4.0 International License - http://creativecommons.org/licenses/by-sa/4.0/
* @link https://github.org/intrd/php-bitcointicker-cmdline/
* Dependencies: Yes, see README.md
*/
```

## System installation
```
apt-get update & apt-get upgrade
apt-get install php5-curl php5-sqlite php5-cli php5-mcrypt
```

## Installation & Dependencies.. 
```
git clone http://github.com/intrd/php-bitcointicker-cmdline/

Stay outside and clone all dependencies below..
git clone http://github.com/intrd/php-common/
mkdir TMP
```

# .conkyrc usage sample
![shot1](/shots/1.jpg?raw=true "conky bitcoin script 1")

... add this to your .conkyrc
```
${color CC9900}BITCOIN TICKER ${hr 2}$color
${execi 300 php /home/intrd/dev/php-bitcointicker-cmdline/index.php | fold -w85}
${execgraph -l php /home/intrd/dev/php-bitcointicker-cmdline/index.php graph}

```
Where 300 is update interval and w85 is your conky column size.