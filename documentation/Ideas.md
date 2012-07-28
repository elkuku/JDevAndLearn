# Ideas

## Run the selenium server headless

This means in a "virtual display"

* <http://en.wikipedia.org/wiki/Xvfb>
* <https://wiki.jenkins-ci.org/display/JENKINS/Xvfb+Plugin>

Xvfb is already installed on this system. A start script is placed in /etc/init.d/xvfb and cann be called in a root console:

<div class="console">
```
# /etc/init.d/xvfb start
```
</div>

And stopped
<div class="console">
```
# /etc/init.d/xvfb stop
```
</div>

This will start the server on display **99** (hard coded in the init script)

Additionally you have to export the display in your Jenkins config for the desired job.

Add a new shell script and place it before your ant call:

<div class="console">
```
export DISPLAY=:99
```
</div>
