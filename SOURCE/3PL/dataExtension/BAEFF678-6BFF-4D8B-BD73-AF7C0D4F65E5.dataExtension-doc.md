## BAEFF678-6BFF-4D8B-BD73-AF7C0D4F65E5

**Name** (not equal to External Key)**:** APAC MX Nurture Resource Journey - 2025-01-13T060030706

**Description:** n/a

**Folder:** Data Extensions/

**Fields in table:** 12

**Sendable:** Yes (`CampaignMember:Common:Id` to `Subscriber Key`)

**Testable:** No

**Retention Policy:** none

| Name | FieldType | MaxLength | IsPrimaryKey | IsNullable | DefaultValue |
| --- | --- | --- | --- | --- | --- |
| CampaignMember:Id | Text | 18 | - | - |  |
| CampaignMember:CampaignId | Text | 18 | - | + |  |
| CampaignMember:Title | Text | 128 | - | + |  |
| CampaignMember:Country | Text | 80 | - | + |  |
| CampaignMember:Common:Id | Text | 18 | - | - |  |
| CampaignMember:Common:Email | EmailAddress | 80 | - | + |  |
| CampaignMember:Common:HasOptedOutOfEmail | Boolean |  | - | + | False |
| CampaignMember:Common:FirstName | Text | 40 | - | + |  |
| CampaignMember:Common:LastName | Text | 80 | - | + |  |
| CampaignMember:Campaign:Id | Text | 18 | - | + |  |
| CampaignMember:Campaign:Name | Text | 80 | - | + |  |
| MemberRecordType | Text | 20 | - | - |  |
