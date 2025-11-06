## 3P Test Users - 920957292_SimulationSupportDE_4725

**Description:** Used by MC developers and testers to test new Journeys

**Folder:** Data Extensions/Test/

**Fields in table:** 6

**Sendable:** Yes (`Id` to `Subscriber Key`)

**Testable:** Yes

**Retention Policy:** none

| Name | FieldType | MaxLength | IsPrimaryKey | IsNullable | DefaultValue |
| --- | --- | --- | --- | --- | --- |
| Id | Text | 100 | + | - |  |
| Name | Text | 50 | - | - |  |
| Region | Text | 10 | - | + |  |
| Email | EmailAddress | 254 | - | + |  |
| Has Clicked Email Link | Boolean |  | - | + |  |
| SimulationOverrideEmail | EmailAddress | 254 | - | + |  |
