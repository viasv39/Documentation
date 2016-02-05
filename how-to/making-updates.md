# Making Updates To Repo

Hey all, I decided to add a quick how to on making updates to the Github repo.

---

## The Setup

This will setup the repo locally on your machine.

### Forking The Repo

Its good practice to utilize "pull requests" when making changes. To do this:

1. Navigate to the [Github repo](https://github.com/danielmj/CSC190)
2. Click "Fork" in the top right. This will essentially make a copy of the repo and put it in your profile.
3. Navigate to your fork: `https://github.com/<your-github-username>/CSC190` replacing `<your-github-username>` with your github handle.
4. Copy the url next to "HTTPS"

### Creating Local Clone

1. Install Git on your machine: [Instructions](https://help.github.com/articles/set-up-git/)
2. Open terminal or command prompt(Windows)
3. Navigate to the folder on the command line where you want to store the directory
4. Type:
```bash
git clone <paste-HTTPS-url-from-your-Github-fork>
```

### Add "upstream" Remote URL to Pull Latest Code

Eventually, someone else will make a change to the repo. You will need to be proactive about pulling the latest code so that you can minimize conflicts.

1. Open the command line again and navigate to the folder
2. Type the following:

```bash
git remote add upstream https://github.com/danielmj/CSC190      # This is the master branch
```

3. View your remotes:

```bash
git remote -v 		# This will show all of the remote urls that you have stored

# You should have 4 lines that look like this:
# upstream 	https://github.com/danielmj/CSC190.git (fetch)
# upstream 	https://github.com/danielmj/CSC190.git (push)
# origin 	https://github.com/<your-github-username>/CSC190.git (fetch)
# origin 	https://github.com/<your-github-username>/CSC190.git (push)
```
---

## Making Changes

### Pull The Latest Code

1. Open the command line again and navigate to the folder
2. If you have already made changes to the repo, either commit them (see below) or `stash`/`stash pop` them (search google) 
3. Type the following:

```bash
git pull --rebase upstream master		# Pull the master branch from the upstream url and integrate with current code
```

4. If there are conflicts, handle them.

> ***MAKE YOUR CHANGES...***
> ***NOTIFY THE GROUP IN SLACK OF WHAT YOU ARE WORKING ON!!!!!!!***

### Commit & Push Your Changes To Your Fork

1. Open the command line again and navigate to the folder
2. You may want to pull the latest code again.
3. Type the following:

```bash
git status 		# This will tell you what has changed
git add *		# This will add everything to the "HEAD" (basically pending commit)
git status		# Make sure everything that you changed is green (not red)
git commit -m "Info about your commit" 		# commit your changes to your local repo copy
git push origin master	# Push the changes that you made to your master branch to the origin remote url (your fork of the repo)
```

4. Go to your fork and look for your changes:  `https://github.com/<your-github-username>/CSC190`
5. Click create pull request. You should see that the changes are coming from your fork: `<your-github-username>/CSC190  master branch` and going to the base fork: `danielmj/CSC190  master branch`
6. Make notes as to what you are changing
7. Finish creating it and notify the group

---

## Common Commands

```bash
git status
git add *
git add <specific-file-path>
git stash			# Stash your current changes
git stash pop		# Unstash your current changes
git diff				# Show differences
git diff HEAD		# Show differences with what is on the HEAD
git commit -m "Add Message Here" # you can also leave off the `-m "Message` part. It will give you a vim window to type in.
git pull --rebase origin master # pull latest code from the upstream
git push origin master # always push to your fork
```


