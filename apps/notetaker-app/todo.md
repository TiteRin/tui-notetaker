# Links
- [x] A Link should have an URL
- [x] The URL should be validate
- [x] You should be able to create a Link with a valid URL
- [x] You should be able to edit a Link with a valid URL
- [x] You should be able to delete a Link
- [x] A Link should belongs to a Directory
- [ ] A Directory shouldn’t have two Links with the same URL
- [ ] You can print a detail of a Link
- [ ] You can export a detail of a Link

# URL Value Object
- [x] Create a ValueObject representing a URL
- [x] Move the validation and tests
- [x] Link will use the URL Object
- [x] Create a URLCast I guess ?

# CLI 
- [x] Add a Link : php notetaker-app links:add [url] --directory [directory]
- [x] List links : php notetaker-app links:list
- [x] Delete links : php notetaker-app links:delete [id]
- [x] Edit a Link, modifying its url or its title: php notetatker-app links:edit [id] {--set-title} {--set-url}
- [x] List Directory : php notetaker-app directories:list
- [x] Add a Review to a Link: php notetaker-app links:quote [linkId] [review]
- [x] List reviews for a Link: php notetaker-app links:reviews [linkId]
- [x] List reviews for a Directory (grouped by Link): php notetaker-app directory:reviews [directoryId]
- [x] Edit a Review: php notetaker-app reviews:edit [reviewId] [review]
- [x] Delete a Review: php notetaker-app reviews:delete [reviewId]
- [x] Add a Quote to a Link : links:quote [linkId] [quote]
- [x] Add a Review to a Quote : quotes:review [quoteId] [quote]
- [·] Print a Link report : links:print [linkId]
- [ ] Move a Link from a directory to another one : php notetake-app links:edit [id] [--set-directory [directory]]
- [ ] List Links for a Directory : php notetaker-app links:list --directory [directory]
- [ ] Remove empty directories : php notetaker-app directories:prune
- [ ] Add Review to the last Link : links:review --last [quote]
- [ ] Add Review to the last Quote : quotes:review --last [quote]

# Directory
- [x] A Directory should have a name
- [x] A Directory can have 0, 1 or multiple Links
- [x] A Link should belong to 1 Directory
- [x] You should be able to create a Directory
- [x] You should be able to rename a Directory
- [x] You should be able to delete an empty Directory
- [x] You shouldn’t be able to delete a non empty Directory
- [x] You should be able to add a Link to a Directory
- [x] You should be able to create a Link and a Directory in the same command
- [ ] You should be able to edit a Link to change its Directory
- [x] You should be able to fetch the Links from a Directory

# Quote
A Quote is something a bit like a Review, it’s something you add to a Link, but it means it’s from the source material. 
- [x] A Quote has a content
- [x] A Quote can have an author
- [ ] A Quote can have a color
- [x] A Quote belongs to a Link
- [x] A Quote can have many Reviews
- [ ] You can delete a Quote without Reviews
- [ ] You can’t delete a Quote with Reviews

# Reviews
- [x] A Review has a content
- [x] A Review is polymorphic (can belong to Link or Quote)
- [x] Guard: Can’t delete a Link if it has Reviews (including quotes’ reviews)
- [ ] Add confirmation prompt before deleting a review.
- [ ] Validate non-empty content when editing a review.
- [ ] Paginate or limit review listing outputs when large.
- [ ] Allow searching/filtering reviews by keywords.
