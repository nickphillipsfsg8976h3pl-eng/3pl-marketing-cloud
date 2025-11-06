SELECT
  ContactKey,
  ContactFirstName,
  ContactEmail
FROM [APAC_3P0073_EdChatCampaign_AllProd_AU_NZ_LostCustomers_July2021-April2025]
WHERE ContactEmail NOT IN (
  SELECT Email FROM [EdChat Registrations FY25]
)

UNION

SELECT
  ContactKey,
  ContactFirstName,
  ContactEmail
FROM [APAC_3P0073_EdChatCampaign_AllProd_AU_NZ_ExistingCustomers]
WHERE ContactEmail NOT IN (
  SELECT ContactEmail FROM [APAC_3P0073_EdChatCampaign_AllProd_AU_NZ_LostCustomers_July2021-April2025]
)
AND ContactEmail NOT IN (
  SELECT Email FROM [EdChat Registrations FY25]
)

UNION

SELECT
  LeadKey AS ContactKey,
  ContactFirstName,
  Email AS ContactEmail
FROM [APAC_3P0073_EdChat_MX_RE_MS_ANZ_Marketing prospects - Jul 2021 - Present]
WHERE Email NOT IN (
  SELECT ContactEmail FROM [APAC_3P0073_EdChatCampaign_AllProd_AU_NZ_LostCustomers_July2021-April2025]
)
AND Email NOT IN (
  SELECT ContactEmail FROM [APAC_3P0073_EdChatCampaign_AllProd_AU_NZ_ExistingCustomers]
)
AND Email NOT IN (
  SELECT Email FROM [EdChat Registrations FY25]
)
