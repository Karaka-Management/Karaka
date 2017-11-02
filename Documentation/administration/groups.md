# Groups

User groups are used for permission management, process flow as well internally by modules for user grouping. There should be no fear of creating too many user groups. A well structured user group management is key for maintianing permissions and efficient work flow. Don't be afraid to implement many groups for all kinds of purposes. 

User groups can inherit permissions of other user groups. One group can inherit permissions from multiple different groups. It's only important to not create any circular inheritence structures e.g.

    Group A inherits from group B which inherits from group C which however inherits from group A. 

Such a group structure is possible but highly inefficent since all three groups now have the same permissions. Performance wise many groups and complex group relations hardly have any effect.

Permissions in general are following the whitelist approach. You cannot assign permissions that block users from performing or accessing sensitive data and functions, it's only possible to grant users the permissions for accessing these. It's highly recommended to only grant permissions to a group/user in a step-by-step aproach. All changes to groups and permissions for user accounts are logged and can be documented with comments as well documents through file upload.