# Links
- [x] A Link should have an URL
- [x] The URL should be validate
- [x] You should be able to create a Link with a valid URL
- [x] You should be able to edit a Link with a valid URL
- [x] You should be able to delete a Link
- [ ] A Link should belongs to a Directory
- [ ] A Directory shouldn’t have two Links with the same URL

# URL Value Object
- [x] Create a ValueObject representing a URL
- [x] Move the validation and tests 
- [x] Link will use the URL Object
- [x] Create a URLCast I guess ?

# CLI 
- [x] Add a Link : php notetaker-app links:add [url]
- [x] List links : php notetaker-app links:list
- [x] Delete links : php notetaker-app links:rm [id|url]
- [x] Add a link with a directory : php notetaker-app links:add [url] --directory [directory]
- [ ] Move a Link from a directory to another one : php notetake-app links:move [id] --directory [directory]
- [ ] List Directory : php notetatker-app directories:list
- [ ] List Links for a Directory : php notetaker-app links:list --directory [directory]

# Directory
- [x] A Directory should have a name
- [ ] A Directory can have 0, 1 or multiple Links
- [x] A Link should belong to 1 Directory
- [x] You should be able to create a Directory
- [x] You should be able to rename a Directory
- [x] You should be able to delete an empty Directory
- [ ] You shouldn’t be able to delete a non empty Directory
- [ ] You should be able to add a Link to a Directory
- [ ] You should be able to create a Link and a Directory in the same command
- [ ] You should be able to edit a Link to change its Directory
- [ ] You should be able to fetch the Links from a Directory

# Reviews
