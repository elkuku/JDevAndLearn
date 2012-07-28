#!/bin/bash
# This script controls xvfb
#
# OpenSuSE tips: http://www.novell.com/coolsolutions/feature/15380.html
#

XVFB_BIN=`which Xvfb`

# Load the rc.status script for this service.
. /etc/rc.status

# Reset status of this service
rc_reset

case "$1" in
  start)
    echo -n "Starting xvfb server..."
    /usr/bin/Xvfb :99 -ac -screen 0 1024x768x8 &

    # Remember status and be verbose
    rc_status -v
    ;;

  stop)
    echo -n "Shutting down xvfb server..."
    killall Xvfb

    # Remember status and be verbose
    rc_status -v
    ;;
  restart)
    $0 stop
    $0 start

    # Remember status and be quiet
    rc_status
    ;;
  status)
      echo -n "Checking for service bar "
      ## Check status with checkproc(8), if process is running
      ## checkproc will return with exit status 0.

      # Return value is slightly different for the status command:
      # 0 - service up and running
      # 1 - service dead, but /var/run/  pid  file exists
      # 2 - service dead, but /var/lock/ lock file exists
      # 3 - service not running (unused)
      # 4 - service status unknown :-(
      # 5--199 reserved (5--99 LSB, 100--149 distro, 150--199 appl.)

      # NOTE: checkproc returns LSB compliant status values.
      #checkproc $XVFB_BIN
      # NOTE: rc_status knows that we called this init script with
      # "status" option and adapts its messages accordingly.
      rc_status -v
      ;;
  *)
    ## If no parameters are given, print which are avaiable.
#    echo "Usage: $0 {start|stop|status|restart|reload}"
    echo "Usage: `basename $0` {start|stop|status|restart}"
    exit 1
    ;;
esac
