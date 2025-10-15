SELECT
  a.CountryName,
  a.CountryCode,
  b.Region
FROM Country_DE a
INNER JOIN Country_Region_Mapping b on a.CountryName=b.Country