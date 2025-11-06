## 92EBB9BE-D30C-4A16-B0A0-8A36B9EBFEF6

**Name** (not equal to External Key)**:** GLOBAL_3P0030_Student Progress Toolkit - 2020-09-13T190434074

**Description:** n/a

**Folder:** Data Extensions/00_BAU/00_GLOBAL/GLOBAL_3P0030_Student Progress Toolkit/

**Fields in table:** 10

**Sendable:** Yes (`CampaignMember:Common:Id` to `Subscriber Key`)

**Testable:** No

**Retention Policy:** none

| Name | FieldType | MaxLength | IsPrimaryKey | IsNullable | DefaultValue |
| --- | --- | --- | --- | --- | --- |
| CampaignMember:Id | Text | 18 | - | - |  |
| CampaignMember:Title | Text | 128 | - | + |  |
| CampaignMember:Common:Id | Text | 18 | - | - |  |
| CampaignMember:Common:Email | EmailAddress | 80 | - | + |  |
| CampaignMember:Common:HasOptedOutOfEmail | Boolean |  | - | + | False |
| CampaignMember:Common:FirstName | Text | 40 | - | + |  |
| CampaignMember:Common:Title | Text | 128 | - | + |  |
| CampaignMember:Common:LastName | Text | 80 | - | + |  |
| CampaignMember:Campaign:Id | Text | 18 | - | + |  |
| MemberRecordType | Text | 20 | - | - |  |
