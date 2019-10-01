# <CLIENT-NAME>

## Key Contacts

**<CLIENT-NAME>**
- <Contact Name>: Primary Contact

**Make Do**
- <Contact Name>: Primary Contact
- <Contact Name>: Accounts
- <Contact Name>: Technical Management
- <Contact Name>: Technical Direction
- <Contact Name>: Engineering

## Environments
- `master` branch **auto** deploys to **PRODUCTION** (https://domain.com/), only use when you are deploying a feature.
- `staging` branch **auto** deploys to **STAGING** (https://domain.wpengine.com) use for client demo.
  - *HTTP Username: demo Password: makedo*
- `develop` branch **auto** deploys to **DEVELOPMENT** (https://domain.wpengine.com) use for general development work, no restrictions.
  - *HTTP Username: demo Password: makedo*

## Managing Issues
- View all issues relating to this project here: https://github.com/orgs/mkdo/projects/1?card_filter_query=repo%3Amkdo%2F<CLIENT-SLUG>+is%3Aissue+is%3Aopen
- Issues are in priority order top to bottom
- `Sprint Cycle` is every 2 weeks. Issues to be worked on in the current `Sprint` are in the `Sprint Backlog` column
- When you are working on an issue, make sure it has been moved from the `Sprint Backlog` into the `In Progress` column
- When you have finished working on an issue, ensure to move it from `In Progress` to `Code Review` also be sure that you have added the `PR Ready` label.
- When you have created a PR and moved your issue to `Code Review` be sure to inform the project channel in Slack that there is a PR ready for review, with a link to the PR.
- A team member will review your PR, and inform you **if** you should merge the PR (and close the issue) or they will leave feedback to be implemented.
- Once the issue has been closed, move the issue from `Code Review` to `Ready to Deploy`

## Branching and merging
- When you start work on an issue, create a new branch for that issue from `master` (that includes the issue number) such as `458-make-header-dark-blue`
  - `git checkout master`
  - `git pull origin master`
  - `git checkout -b 458-make-header-dark-blue`
- Make regular commits to the branch, and push them to the repository on that branch often. In your commit message be sure to include the issue number, eg: `git commit -m "#458 - Make header dark blue"`
- When you have completed the issue, create a PR by choosing the branch in GitHub and clicking the `New Pull Request` button
- Be sure you have setup all the testing steps you need (as per the *Creating a PR* section below)
- When you have created a PR be sure to inform the project channel in Slack that there is a PR ready for review, with a link to the PR.
- Once the PR has been merged to the `master` or `feature` branch, the branch you created will be deleted

## Creating a PR / Prepairing for QA
- A PR will be used for QA, Testing and Code Quality checking.
- In the PR be sure to include all the steps needed for testing, including any data that may need to be added
- Be sure that the opening line states which branch it fixes eg `Fixes #458`
- Provide images, or even a short screen recording to show the new expected functionality
- You may need to show a before and after, so the tester knows what they are looking for, especially if they are not familar with the project
- Merge your branch to the `develop` branch
- Input all of the test data that you need to demonstrate the fix into the `development` environment
- Inform the project channel in Slack that there is a PR ready for review, with a link to the PR.

## Once a PR has been approved for deploy
- Merge the PR into the `staging` branch
- Input all of the test data that you need to demonstrate the fix into the `staging` environment
- **Close the issue**
- Move the task into the `Ready to deploy` column
- Inform the Project Manager they can demonstrate the change to the client.
- Any feedback will come back at this stage as a **NEW** issue. 

## Once the client has approved the changes
- The feature will be merged into `master`
- A tagged release must be created on GitHub using semantic versioning, referencing all the PRs that have been merged into `master` since the last release.
- The test information on the PR will be used to populate the Live environment with data.

## Performing a Code Review
- A reviewer *must* pull down the branch that contains the changes, and test them on their local build
- They should input the test data provided by the person that submitted the PR
- The full contents of a PR can be reviewed by appending `/files` to the end of the GitHub URL
- Check for code quality, more performant methods of doing things, code standards and leave feedback
- Once it has all been checked, and the reviewer is happy that everything has passed, they should inform the submiter that they can close the issue (and perhaps merge, depending on the review work flow)

## How to get up and running with the code base
- SQL and Uploads can be accessed directly from WPEngine, however if you do not have access to these they will be provided.
- Download the repository from Git into your working directory `git clone https://github.com/mkdo/<CLIENT-SLUG>.git`
- Using the environment of your choice (VVV, Valet, MAMP etc...) create a site called `garthwest.test`
- Import the SQL file into the created `<CLIENT-SLUG>` database
- Import the uploads folder into the `<CLIENT-SLUG>/build/wp-content/uploads` folder
- From the root of the `garthwest` folder build the assets buy running:
  - `npm install`
  - `bower install`
  - `grunt`
- Navigate to https://<CLIENT-SLUG>.test and you should be ready to start work
- You can log into the admin at https://<CLIENT-SLUG>.test/wp-admin and the password will be in our 1Password system (if you do not have access this will be provided)

## GitHub Labels
There are a wide range of labels in the GitHub repository, all which serve different purposes. Here is an overview of what they are for:

- `- XS -`, `- S -`, `- M -`, `- L -` are labels for sprint planning. There is only so much time in a Sprint, and these give an indication of roughly how long a task will take. They essentially take the place of 'story points' which have been found to be confusing, and are assigned before a sprint, and adjusted on Sprint Kickoff. They are:
  - `- XS -` will roughly take 1-2 hours, so you can get 3-4 of these done in a day.
  - `- S -` will roughly take 4-6 hours, so you can get 1-2 of these done in a day.
  - `- M -` will roughly take 1-2 days.
  - `- L -` will roughly take a week. In theory an `- L -` should be broken down into smaller tasks however, so should never really be used, but instead is as an indicator to the sprint manager that an adjustment is needed.

- `Next Sprint` should be used to plan out the next sprint before the current sprint has been completed, so they issues can be moved accross as soon as the current sprint is finished.

- `Must Have`, `Should Have`, `Could Have`, `Wont Fix` are priority labels for sprint planning. If there is a backlog of items, it stands to reason that the ones which are a 'Must' should be tackled first. The `Could Have`'s are 'nice to haves', for instance they are perhaps are non-critical features which have been suggested by the technical team.
  - `Wont Fix` will be closed as soon as the decision has been made not to fix the issue. The label serves as a quick overview as to the status of the issue, and opening the issue should reveal the note as to why the decision not to fix was made.

- `Epic` this should be used sparingly, as it is very rare that a feature is large enough to need it, however when it is used, it is for project management purposes to track the status of a large feature with many sub features. 

- `Documentation`, `Content`, `UX / UI`, `Testing` all of these are optional labels, to indicate the type of category the issue falls under, to assist the technical team.

- `Bug`, `Enhancement` indicates if this is a bug in an existing feature, or a new feature. It helps the technical team determine the approach, as an `Enhancement` will need a technical soloution, where as a bug will need existing code ammendments. 

- `Blocked`, `Frozen` a blocked issue is an issue that cannot be progressed because of missing information or a dependancy. A `Frozen` issue is an issue that is on hold because of a client decision, but may be revisited. 

- `Duplicate` is a duplicate issue that is fixed by another task. The issue that is duplicated should be refernced on this issue, and the issue closed as soon as it is confirmed that the issue is a duplicate.

- `Discovery` is an issue that cannot be progressed because a descussion is needed. It is supliemented with the label `[Spike]` in the title. A spike cannot be estimated, however the complexity of the descussion to resolve the spike is what the estimate means in this instance.

- `PR Ready` an issue remains open until the PR has been reviewed and approved. To help engineers focus on open issues that have no PR, this label can be used to filter issues. 

- `DO NOT MERGE` should be applied to PR's only, it is a way of indicating that a PR should not be merged currently, due to some external factor that will be written as a comment on the PR. This is different from a draft PR, as a draft PR indicates that work is being carried out on the PR, whereas a PR with `DO NOT MERGE` applied should be completed, just awaiting conditions for deploy (IE some content changes may be needed).

## Sprint Cycle
- Sprints are managed in a 2 week cycle
- The start of a sprint has a `Sprint Kickoff` where we discuss the theme of the sprint, and which features we will deliver in the two week period
- We will have an optional `Refinement Meeting` mid way through the sprint, to monitor progress, and adjust the sprint appropriately
- Will will wrap up the sprint with a `Sprint Retrospective` where we talk about what went well, not so well, what we learned and what still puzzles us

## Sprint Kickoff
The kickoff introduces the theme of the current sprint, sets out expectations of what should be delivered, and ensures that an understanding of each task within that sprint is understood, and an accurate estimate has been placed on it.

## Sprint Refinement
An optional sprint refinement allows the sprint to be revisited, and the sprint to be adjusted to allow for any unforseen circumstnaces and priorities. 

## Sprint Retrospective
In a retrospective, everyone involved in the sprint should be given the opportunity to share topics in the following areas:
- What went well
- What went not so well
- What did we learn
- What still puzzles us

After those topics have been shared, the chair will go through each one, ask questions and log actions to help with future sprints and projects.

## Adding Additional Issues to a Sprint (while it is in progress)
All clients have priorities, and changing needs, but there is only so much time within a sprint. When a sprint is fully in progress, there will be tasks assigned to it that match with the amount of availability available in that sprint (EG: it could be an M, an S and 4 XS;s).

When priorities change, it is the responsibility of the person requesting the change to either remove tasks out of the sprint which are the equivilent value of the new one being placed in, or agree and approve overtime for the task to be added to the sprint out of hours.
