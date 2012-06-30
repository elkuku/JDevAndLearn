## Jenkins Kickstart

This script will create a sample PHP project, a git repository and set up a Jenkins build job.

### How To

Open a console (anywhere) and type ```jenkinskickstart``` &mdash; (actually just ```je <TAB>``` will trigger the bash completion)

**Output:**

```
$ jenkinskickstart

     ======================
     == Jenkins Template ==
     ======================

Project: JenkinsDemo
Repo: /home/jtester/repos
Templates: /home/jtester/repos/JDevLearn/scripts/build/template

Setting up repository in /home/jtester/repos/JenkinsDemo
Initialized empty Git repository in /home/jtester/repos/JenkinsDemo/.git/
Initial commit
[master (root-commit) 8be580c] initial import
 6 files changed, 413 insertions(+), 0 deletions(-)
 create mode 100644 build/build.xml
 create mode 100644 build/phpdox.xml
 create mode 100644 build/phpmd.xml
 create mode 100644 build/phpunit.xml
 create mode 100644 component/admin/com_demo/demo.php
 create mode 100644 tests/unit/demotest.php
ok
Setting up Jenkins project in /home/jtester/.jenkins/jobs/JenkinsDemo
ok

Finished =;)
```

**Thats it !**

If your Jenkins server is already running, go to ```Jenkins``` &rArr; ```Manage Jenkins``` and hit ```Reload configuration from disk```

If the server is not running yet, start it using the {{icon|beakermenu}} Menu: ```Server``` &rArr; ```Jenkins```.

Now visit: <http://localhost:8080>

You should see your new "Job" on the list. Click on the name and hit ```Build now```.

Your first build should be running right now and should result.... UNSTABLE *cry*...

OK, to get the stats set up and running, just hit ```Build now``` again.

The errors and warning you recieve are expected.

Your code repository is located at ```/home/jtester/repos/JenkinsDemo``` &mdash; go for it !

Can you turn the build to stable ? ```;)```

### The Result:

{{image|JenkinsDemo01.png|800|Jenkins Demo}}

Awaiting your code....
