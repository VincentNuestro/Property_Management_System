-- Database: gates_smm3
-- Generated from: gates_smm March 3, 2020.sql
-- Total Tables: 312
-- Extracted: Fri Oct 31 14:10:41 2025
-- Note: Schema only, data inserts removed

-- TABLE LIST:
-- ================================================================================
--   1. categories
--   2. db_discount
--   3. db_paymenttypes
--   4. db_perhour
--   5. db_sales
--   6. db_settimeupload
--   7. db_syncfilestat
--   8. db_void
--   9. dunn_aging
--  10. dunn_soadate
--  11. dunn_tblprevsoa
--  12. dunn_tblsoa_dummy
--  13. dunn_tblsoadetails
--  14. dunn_tblsoadetails_copy
--  15. dunn_tblsoaheader
--  16. dunn_tblsoaheader_copy
--  17. dunn_tblsoavacant
--  18. emergency_details
--  19. emergency_header
--  20. event_attachments
--  21. event_dayactivity
--  22. event_facilities
--  23. event_header
--  24. event_manpower
--  25. event_organizer
--  26. event_paraphernalia
--  27. event_personnel
--  28. event_promotional
--  29. event_requirements
--  30. event_soundsystem
--  31. fdb_discount
--  32. fdb_not_paymenttypes
--  33. fdb_paymenttypes
--  34. fdb_perhour
--  35. fdb_sales
--  36. fdb_salesbymn
--  37. fdb_void
--  38. mall_directory_categories
--  39. mall_directory_floors
--  40. mall_directory_other_coordinates
--  41. mall_directory_others
--  42. mall_directory_recordid
--  43. mall_directory_route
--  44. mall_directory_shops
--  45. mall_directory_shops_coordinates
--  46. mall_directory_top_searches
--  47. mall_setup
--  48. pmls_android_location_task
--  49. pmls_android_reffield
--  50. pmls_android_reflocation
--  51. pmls_android_refroom
--  52. pmls_android_reftask
--  53. pmls_android_user
--  54. pmls_android_worker_task
--  55. pmls_android_worker_task_history
--  56. products
--  57. ref_maintenancemain
--  58. ref_maintenancemain_log
--  59. ref_maintenancemain_sub
--  60. refrecordid
--  61. refrecordid_mall
--  62. sdb_discount
--  63. sdb_not_paymenttypes
--  64. sdb_paymenttypes
--  65. sdb_perhour
--  66. sdb_sales
--  67. sdb_salesbymn
--  68. sdb_void
--  69. setup_dateevic
--  70. taskheader
--  71. tbl_charges_detail
--  72. tbl_day
--  73. tbl_month
--  74. tbl_tenantspayments
--  75. tbl_visitor
--  76. tblaccreditation
--  77. tblaccreditationdocs
--  78. tblaccreditationlogs
--  79. tblasset_maintenance_d
--  80. tblasset_maintenance_h
--  81. tblchat_header
--  82. tblchat_log
--  83. tblchat_record
--  84. tblcomplaints
--  85. tblcomplaintscode
--  86. tblcondition
--  87. tblcontract
--  88. tblforzreading
--  89. tblgroups
--  90. tbllog_sheet
--  91. tblloggedmachine
--  92. tbllogs_per_trans
--  93. tbllogs_zaputility
--  94. tblmachine
--  95. tblmaintenance_category
--  96. tblmaintenance_charges
--  97. tblmaintenance_department
--  98. tblmaintenance_equip
--  99. tblmaintenance_houserules
-- 100. tblmaintenance_hrviolatorremarks
-- 101. tblmaintenance_hrviolatorremarks_attachment
-- 102. tblmaintenance_hrviolators
-- 103. tblmaintenance_hrviolators_copy
-- 104. tblmaintenance_hrviolatorsheader
-- 105. tblmaintenance_hrviolatorsheader_copy
-- 106. tblmaintenance_hrviolatorsresponse
-- 107. tblmaintenance_hrviolatorsresponse_attachment
-- 108. tblmaintenance_management
-- 109. tblmaintenance_setup
-- 110. tblmaintenance_tasklist
-- 111. tblmaintenance_workorder
-- 112. tblmaintenance_workorderlist
-- 113. tblmaintenance_workorderlist_copy
-- 114. tblref_amenities
-- 115. tblref_applicationrequirements
-- 116. tblref_applicationrequirements2
-- 117. tblref_apprlist
-- 118. tblref_apprlistperuser
-- 119. tblref_asset
-- 120. tblref_billperiod
-- 121. tblref_billperiod_copy
-- 122. tblref_billprofile
-- 123. tblref_bldg
-- 124. tblref_brgy
-- 125. tblref_budget
-- 126. tblref_cardtype
-- 127. tblref_charges
-- 128. tblref_charges_type
-- 129. tblref_citymun
-- 130. tblref_citymun_copy
-- 131. tblref_classification
-- 132. tblref_companyposition
-- 133. tblref_conbond
-- 134. tblref_consologs
-- 135. tblref_contract
-- 136. tblref_csv_upload
-- 137. tblref_dbupdatelogs
-- 138. tblref_employee
-- 139. tblref_event_facilities
-- 140. tblref_event_funit
-- 141. tblref_event_manpower
-- 142. tblref_event_organizer
-- 143. tblref_event_paraphernalia
-- 144. tblref_event_personnel
-- 145. tblref_facilities
-- 146. tblref_filters
-- 147. tblref_floor_lca
-- 148. tblref_floorsetup
-- 149. tblref_floorsetup_copy
-- 150. tblref_flr
-- 151. tblref_groupaccess
-- 152. tblref_groupaccess2
-- 153. tblref_hardcodedid
-- 154. tblref_industry
-- 155. tblref_investigator
-- 156. tblref_investigatorpos
-- 157. tblref_leasingsignatories
-- 158. tblref_location
-- 159. tblref_maintenancetasksetup
-- 160. tblref_maintenancetasksetup_stat
-- 161. tblref_mall
-- 162. tblref_mall_addcharges
-- 163. tblref_mallbankinfo
-- 164. tblref_mallcompany
-- 165. tblref_manpower
-- 166. tblref_merchandise_class
-- 167. tblref_merchandise_depa
-- 168. tblref_merchandisedep_cat
-- 169. tblref_meter
-- 170. tblref_meter_copy
-- 171. tblref_meterlogs
-- 172. tblref_meterlogs_copy
-- 173. tblref_msbilling
-- 174. tblref_msmaintenance_d
-- 175. tblref_msmaintenance_h
-- 176. tblref_operationalcharges
-- 177. tblref_organizerm
-- 178. tblref_paymentsched
-- 179. tblref_penalty
-- 180. tblref_pospaymenttype
-- 181. tblref_process_owner
-- 182. tblref_promotionalp
-- 183. tblref_province
-- 184. tblref_refcharges
-- 185. tblref_refcharges_copy
-- 186. tblref_region
-- 187. tblref_soundnper
-- 188. tblref_source
-- 189. tblref_sqm
-- 190. tblref_tenantsdocs
-- 191. tblref_type
-- 192. tblref_typeofbusiness
-- 193. tblref_typeofpermits
-- 194. tblref_unit
-- 195. tblref_unit_amenities
-- 196. tblref_unit_lca_dummy
-- 197. tblref_unitclass
-- 198. tblref_unitimage
-- 199. tblref_unitlocated
-- 200. tblref_unitplot
-- 201. tblref_unitplot2
-- 202. tblref_usergroupaccess
-- 203. tblref_utilrate
-- 204. tblref_wing
-- 205. tblref_workordermanual
-- 206. tblref_workorderremarks
-- 207. tblrefbank
-- 208. tblrefpaymenttype
-- 209. tblreqcategory
-- 210. tblreqtags
-- 211. tblsys_connsetup
-- 212. tblsys_setup
-- 213. tblsys_setup2
-- 214. tbltenant_chat
-- 215. tbltenant_chat_header
-- 216. tblterms
-- 217. tbltrans_amendment
-- 218. tbltrans_appid
-- 219. tbltrans_bevlist
-- 220. tbltrans_bevlogs
-- 221. tbltrans_chargeesca
-- 222. tbltrans_chargeesca_br
-- 223. tbltrans_chargeesca_br_history
-- 224. tbltrans_chargeesca_history
-- 225. tbltrans_closingmeeting
-- 226. tbltrans_company
-- 227. tbltrans_company_contact_person
-- 228. tbltrans_company_contact_person_contacts
-- 229. tbltrans_company_contacts
-- 230. tbltrans_company_owner_contacts
-- 231. tbltrans_companysig
-- 232. tbltrans_contractsigning
-- 233. tbltrans_demo
-- 234. tbltrans_eod
-- 235. tbltrans_escalation
-- 236. tbltrans_escalation_copy
-- 237. tbltrans_escalation_history
-- 238. tbltrans_events
-- 239. tbltrans_hierarchy
-- 240. tbltrans_hierarchy_reqgroup
-- 241. tbltrans_inquiry
-- 242. tbltrans_inquiry_copy
-- 243. tbltrans_inquiry_copy1
-- 244. tbltrans_inquiry_history
-- 245. tbltrans_inquiry_unit
-- 246. tbltrans_inquiry_unit_history
-- 247. tbltrans_items
-- 248. tbltrans_lca_plot
-- 249. tbltrans_leads
-- 250. tbltrans_leads_activities
-- 251. tbltrans_leads_attachments
-- 252. tbltrans_leads_awareness
-- 253. tbltrans_leads_closingmeeting
-- 254. tbltrans_leads_contractsigning
-- 255. tbltrans_leads_demo
-- 256. tbltrans_leads_referral
-- 257. tbltrans_leasingapplication
-- 258. tbltrans_leasingapplication_affiliated
-- 259. tbltrans_leasingapplication_contactperson
-- 260. tbltrans_leasingapplication_dp
-- 261. tbltrans_leasingapplication_owner_telno
-- 262. tbltrans_leasingapplicationreq
-- 263. tbltrans_mallconf
-- 264. tbltrans_memo
-- 265. tbltrans_memo_attachment
-- 266. tbltrans_paymentapplogs
-- 267. tbltrans_paymentapplogs_copy
-- 268. tbltrans_pdc
-- 269. tbltrans_processedbill
-- 270. tbltrans_processedsoa
-- 271. tbltrans_procharges
-- 272. tbltrans_procharges_history
-- 273. tbltrans_proposal
-- 274. tbltrans_proposal_history
-- 275. tbltrans_proposal_pass
-- 276. tbltrans_proposal_unit
-- 277. tbltrans_proposal_unit_history
-- 278. tbltrans_prospects
-- 279. tbltrans_referral
-- 280. tbltrans_remarks
-- 281. tbltrans_remarks_attach
-- 282. tbltrans_renew_contract
-- 283. tbltrans_renew_contract_charges
-- 284. tbltrans_renew_contract_charges_esca
-- 285. tbltrans_renew_contract_charges_esca_br
-- 286. tbltrans_renew_contract_esca
-- 287. tbltrans_renew_contract_unit
-- 288. tbltrans_reservation
-- 289. tbltrans_tenants
-- 290. tbltrans_tenants_copy
-- 291. tbltrans_tenants_dummy
-- 292. tbltrans_tenants_history
-- 293. tbltrans_tenantsrequest
-- 294. tbltrans_tenantsrequest_items
-- 295. tbltrans_tenantsrequest_visitor
-- 296. tbltrans_trade_contact_person
-- 297. tbltrans_trade_contact_person_list
-- 298. tbltrans_tradename
-- 299. tbltransaction
-- 300. tbltransaction_
-- 301. tbltransaction_1127
-- 302. tbltransaction_copy
-- 303. tbltransaction_soa
-- 304. tbltransleasing_contactlist
-- 305. tbltransleasing_inquiry
-- 306. tblunit_statuslogs
-- 307. tblunit_statuslogs_blanck
-- 308. tbluser
-- 309. tblxreadinglogs
-- 310. tblzreadinglogs
-- 311. trans_leads
-- 312. ttblref_refcitymun
-- ================================================================================


-- Table: categories
CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL AUTO_INCREMENT,
  `categoryName` varchar(100) NOT NULL,
  PRIMARY KEY (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_discount
CREATE TABLE `db_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(20) DEFAULT NULL,
  `fvcDscntCd` varchar(20) DEFAULT NULL,
  `fvcDscntPrcntg` float(20,2) DEFAULT NULL,
  `fnmDscnt` float(20,2) DEFAULT NULL,
  `fnmCntDcmnt` float(20,2) DEFAULT NULL,
  `fnmCntCstmr` float(20,2) DEFAULT NULL,
  `fnmCntSnrCtzn` float(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_paymenttypes
CREATE TABLE `db_paymenttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(20) DEFAULT NULL,
  `fvcPymntCd` varchar(10) DEFAULT NULL,
  `fvcPymntDsc` varchar(20) DEFAULT NULL,
  `fvcPymntCdCLSCd` float(20,2) DEFAULT NULL,
  `fvcPymntCdCLSDsc` varchar(30) DEFAULT NULL,
  `fnmPymnt` float(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_perhour
CREATE TABLE `db_perhour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` varchar(20) DEFAULT NULL,
  `fvcMrchntCd` varchar(20) DEFAULT NULL,
  `fvcHRLCd` time DEFAULT NULL,
  `fnmDlySls` float(20,2) DEFAULT NULL,
  `fnmCntDcmnt` float(20,2) DEFAULT NULL,
  `fnmCntCstmr` float(20,2) DEFAULT NULL,
  `fnmCntSnrCtzn` float(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_sales
CREATE TABLE `db_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(30) DEFAULT NULL,
  `tenantid` varchar(30) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(30) DEFAULT NULL,
  `fvcMrcntDsc` text,
  `fnmGrndTtlOld` float(20,2) DEFAULT NULL,
  `fnmGrndTtlNew` float(20,2) DEFAULT NULL,
  `fnmGTDlySls` float(20,2) DEFAULT NULL,
  `fnmGTDscnt` float(20,2) DEFAULT NULL,
  `fnmGTDscntSNR` float(20,2) DEFAULT NULL,
  `fnmGTDscntPWD` float(20,2) DEFAULT NULL,
  `fnmGTDscntGPC` float(20,2) DEFAULT NULL,
  `fnmGTDscntVIP` float(20,2) DEFAULT NULL,
  `fnmGTDscntEMP` float(20,2) DEFAULT NULL,
  `fnmGTDscntREG` float(20,2) DEFAULT NULL,
  `fnmGTDscntOTH` float(20,2) DEFAULT NULL,
  `fnmGTRfnd` float(20,2) DEFAULT NULL,
  `fnmGTCncld` float(20,2) DEFAULT NULL,
  `fnmGTSlsVAT` float(20,2) DEFAULT NULL,
  `fnmGTVATSlsInclsv` float(20,2) DEFAULT NULL,
  `fnmGTVATSlsExclsv` float(20,2) DEFAULT NULL,
  `fnmOffclRcptBeg` float(20,2) DEFAULT NULL,
  `fnmOffclRcptEnd` float(20,2) DEFAULT NULL,
  `fnmGTCntDcmnt` float(20,2) DEFAULT NULL,
  `fnmGTCntCstmr` float(20,2) DEFAULT NULL,
  `fnmGTCntSnrCtzn` float(20,2) DEFAULT NULL,
  `fnmGTLclTax` float(20,2) DEFAULT NULL,
  `fnmGTSrvcChrg` float(20,2) DEFAULT NULL,
  `fnmGTSlsNonVat` float(20,2) DEFAULT NULL,
  `fnmGTRwGrss` float(20,2) DEFAULT NULL,
  `fnmGTLclTaxDly` float(20,2) DEFAULT NULL,
  `fvcWrksttnNmbr` varchar(30) DEFAULT NULL,
  `fnmGTPymntCSH` float(20,2) DEFAULT NULL,
  `fnmGTPymntCRD` float(20,2) DEFAULT NULL,
  `fnmGTPymntOTH` float(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_settimeupload
CREATE TABLE `db_settimeupload` (
  `timetosave` time DEFAULT '00:00:00',
  `hours` varchar(2) DEFAULT NULL,
  `minuto` varchar(2) DEFAULT NULL,
  `ampm` varchar(2) DEFAULT NULL,
  `penalty` float(20,2) DEFAULT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `synctype` tinyint(5) DEFAULT NULL,
  `filesyncsetup` tinyint(5) DEFAULT '1',
  `ConsoSetup` tinyint(5) DEFAULT '0',
  `ConsoDay` tinyint(5) DEFAULT NULL,
  `ConsoTime` time DEFAULT NULL,
  `CSVSource` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_syncfilestat
CREATE TABLE `db_syncfilestat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refno` varchar(10) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `sales` tinyint(1) DEFAULT '0',
  `discount` tinyint(1) DEFAULT '0',
  `void_refund` tinyint(1) DEFAULT '0',
  `salesperhour` tinyint(1) DEFAULT '0',
  `paymenttype` tinyint(1) DEFAULT '0',
  `reportDate` date DEFAULT NULL,
  `countSync` int(1) DEFAULT NULL,
  `penalty` int(1) DEFAULT '0',
  `uploaded` tinyint(1) DEFAULT '0',
  `VAL_STAT` tinyint(1) DEFAULT '0',
  `sales_stat` tinyint(1) DEFAULT '0',
  `discount_stat` tinyint(1) DEFAULT '0',
  `void_stat` tinyint(1) DEFAULT '0',
  `salesperhour_stat` tinyint(1) DEFAULT '0',
  `paymenttype_stat` tinyint(1) DEFAULT '0',
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `id` (`id`),
  KEY `IDX_refno` (`refno`),
  KEY `IDX_reportDate` (`reportDate`),
  KEY `IDX_TenantID` (`tenantID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: db_void
CREATE TABLE `db_void` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(20) DEFAULT NULL,
  `fvcRfndCncldCd` varchar(20) DEFAULT NULL,
  `fvcRfndCncldRsn` varchar(50) DEFAULT NULL,
  `fnmAmt` float(20,2) DEFAULT NULL,
  `fnmCntDcmnt` float(20,2) DEFAULT NULL,
  `fnmCntCstmr` float(20,2) DEFAULT NULL,
  `fnmCntSnrCtzn` float(20,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_aging
CREATE TABLE `dunn_aging` (
  `Customer_ID` varchar(200) DEFAULT NULL,
  `Reference` varchar(200) DEFAULT NULL,
  `Customer_Name` varchar(500) DEFAULT NULL,
  `xterms` varchar(50) DEFAULT NULL,
  `Due_Date` datetime DEFAULT NULL,
  `xBalance` decimal(19,4) DEFAULT '0.0000',
  `transdate` date DEFAULT NULL,
  `accode` varchar(50) DEFAULT '',
  `acname` varchar(250) DEFAULT '',
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `xproc` decimal(10,2) DEFAULT '0.00',
  `xesca` decimal(10,2) DEFAULT '0.00',
  `xactiv` tinyint(1) DEFAULT '0',
  `xcntrl` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `Customer_ID` (`Customer_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_soadate
CREATE TABLE `dunn_soadate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `refdate` date DEFAULT NULL,
  `isMerchant` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_tblprevsoa
CREATE TABLE `dunn_tblprevsoa` (
  `mainsoaid` varchar(40) DEFAULT '',
  `soaid` varchar(40) DEFAULT '',
  `Amount` double(40,6) DEFAULT '0.000000',
  `pmemno` varchar(100) DEFAULT '',
  `billperiod` varchar(100) DEFAULT '',
  `pperiod` varchar(50) DEFAULT '',
  `psoyear` int(5) DEFAULT '0',
  `psomonth` int(3) DEFAULT '0',
  `pfrom` date DEFAULT NULL,
  `pto` date DEFAULT NULL,
  KEY `idxmain` (`mainsoaid`(15)),
  KEY `idxsoa` (`soaid`(15)),
  KEY `idxmemno` (`pmemno`(16)),
  KEY `idxper` (`psoyear`,`psomonth`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_tblsoa_dummy
CREATE TABLE `dunn_tblsoa_dummy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `soaid` varchar(40) DEFAULT '',
  `customer_id` varchar(100) DEFAULT '',
  `soayear` varchar(4) DEFAULT '',
  `soamonth` varchar(2) DEFAULT '',
  `totalamount` double(40,6) DEFAULT '0.000000',
  `createdby` varchar(40) DEFAULT '',
  `datecreated` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `soaidd` varchar(40) DEFAULT '',
  `folio` varchar(40) DEFAULT '',
  `roomno` varchar(40) DEFAULT '',
  `trcode` varchar(40) DEFAULT '',
  `xdesc` varchar(200) DEFAULT '',
  `guestname` text,
  `xamount` double(40,6) DEFAULT '0.000000',
  `xdate` date DEFAULT NULL,
  `csalutation` varchar(200) DEFAULT '',
  `customer_name` varchar(100) DEFAULT '',
  `caddress` varchar(200) DEFAULT '',
  `ccity` varchar(200) DEFAULT '',
  `caddress2` varchar(200) DEFAULT '',
  `ccountry` varchar(200) DEFAULT '',
  `memno` varchar(50) DEFAULT '',
  `memdues` decimal(10,2) DEFAULT '0.00',
  `consu` decimal(10,2) DEFAULT '0.00',
  `outletdesc` text,
  `forwbal` decimal(10,2) DEFAULT '0.00',
  `currcharg` decimal(10,2) DEFAULT '0.00',
  `payment` decimal(10,2) DEFAULT '0.00',
  `currbal` decimal(10,2) DEFAULT '0.00',
  `xstatus` varchar(200) DEFAULT '',
  `customer_name1` varchar(100) DEFAULT '',
  `outletc` varchar(20) DEFAULT '',
  `isconc` tinyint(5) DEFAULT '0',
  `consucredit` decimal(10,2) DEFAULT '0.00',
  `billno` varchar(30) DEFAULT '',
  `isvptyp` varchar(5) DEFAULT '',
  `b13` decimal(10,2) DEFAULT '0.00',
  `b36` decimal(10,2) DEFAULT '0.00',
  `b69` decimal(10,2) DEFAULT '0.00',
  `b99` decimal(10,2) DEFAULT '0.00',
  `b00` decimal(10,2) DEFAULT '0.00',
  `pleft` decimal(10,2) DEFAULT '0.00',
  `penchrg` decimal(10,2) DEFAULT '0.00',
  `cn` varchar(20) DEFAULT '',
  `soaperiod` date DEFAULT NULL,
  `soaperiod2` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idxsoa` (`soaid`(20)),
  KEY `idxmem` (`customer_id`(16)),
  KEY `idxper` (`soayear`,`soamonth`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_tblsoadetails
CREATE TABLE `dunn_tblsoadetails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soaNo` varchar(30) NOT NULL,
  `tenantid` varchar(20) NOT NULL,
  `xcode` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `amount` decimal(40,2) NOT NULL DEFAULT '0.00',
  `qty` decimal(40,2) NOT NULL DEFAULT '0.00',
  `paymentamount` decimal(40,2) DEFAULT '0.00',
  `vatamount` decimal(40,2) DEFAULT '0.00',
  `balance` decimal(40,2) DEFAULT '0.00',
  `xdate` date NOT NULL,
  `reference` varchar(100) NOT NULL,
  `xdatetime` datetime NOT NULL,
  `isPenalty` int(1) NOT NULL DEFAULT '0',
  `paymenttype` varchar(15) NOT NULL,
  `cardholder` varchar(50) NOT NULL,
  `ccno` varchar(30) NOT NULL,
  `expdate` varchar(15) NOT NULL,
  `checkno` varchar(30) NOT NULL,
  `checkdate` date NOT NULL,
  `checkname` varchar(50) NOT NULL,
  `bankname` varchar(20) NOT NULL,
  `cardtype` varchar(50) DEFAULT NULL,
  `authno` varchar(10) DEFAULT NULL,
  `secno` varchar(10) DEFAULT NULL,
  `orno` varchar(20) NOT NULL,
  `totalamount` decimal(40,2) NOT NULL DEFAULT '0.00',
  `tenanttype` varchar(20) NOT NULL,
  `revpercent` varchar(5) NOT NULL,
  `bnkfrom` varchar(50) DEFAULT NULL,
  `bnkto` varchar(50) DEFAULT NULL,
  `accnofrom` varchar(50) DEFAULT NULL,
  `accnoto` varchar(50) DEFAULT NULL,
  `xdescription` varchar(150) DEFAULT NULL,
  `isMerchant` int(5) DEFAULT '0',
  `merchant_code` varbinary(10) DEFAULT NULL,
  `isAdjustment` tinyint(5) DEFAULT '0',
  `isRefund` tinyint(5) DEFAULT '0',
  `isGenerated` tinyint(5) DEFAULT '0',
  `InquiryID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tenantid` (`tenantid`(11)),
  KEY `xdate` (`xdate`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- Table: dunn_tblsoadetails_copy
CREATE TABLE `dunn_tblsoadetails_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soaNo` varchar(30) NOT NULL,
  `tenantid` varchar(20) NOT NULL,
  `xcode` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `amount` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `qty` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `paymentamount` decimal(30,6) DEFAULT '0.000000',
  `vatamount` decimal(30,6) DEFAULT '0.000000',
  `balance` decimal(30,6) DEFAULT '0.000000',
  `xdate` date NOT NULL,
  `reference` varchar(100) NOT NULL,
  `xdatetime` datetime NOT NULL,
  `isPenalty` int(1) NOT NULL DEFAULT '0',
  `paymenttype` varchar(15) NOT NULL,
  `cardholder` varchar(50) NOT NULL,
  `ccno` varchar(30) NOT NULL,
  `expdate` varchar(15) NOT NULL,
  `checkno` varchar(30) NOT NULL,
  `checkdate` date NOT NULL,
  `checkname` varchar(50) NOT NULL,
  `bankname` varchar(20) NOT NULL,
  `cardtype` varchar(50) DEFAULT NULL,
  `authno` varchar(10) DEFAULT NULL,
  `secno` varchar(10) DEFAULT NULL,
  `orno` varchar(20) NOT NULL,
  `totalamount` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `tenanttype` varchar(20) NOT NULL,
  `revpercent` varchar(5) NOT NULL,
  `bnkfrom` varchar(50) DEFAULT NULL,
  `bnkto` varchar(50) DEFAULT NULL,
  `accnofrom` varchar(50) DEFAULT NULL,
  `accnoto` varchar(50) DEFAULT NULL,
  `xdescription` varchar(150) DEFAULT NULL,
  `isMerchant` int(5) DEFAULT '0',
  `merchant_code` varbinary(10) DEFAULT NULL,
  `isAdjustment` tinyint(5) DEFAULT '0',
  `isRefund` tinyint(5) DEFAULT '0',
  `isGenerated` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `tenantid` (`tenantid`(11)),
  KEY `xdate` (`xdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_tblsoaheader
CREATE TABLE `dunn_tblsoaheader` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `soaid` varchar(40) NOT NULL,
  `tenantid` varchar(40) DEFAULT NULL,
  `tenantname` text,
  `totalamount` decimal(40,2) DEFAULT '0.00',
  `createdby` varchar(40) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `tenantdues` decimal(40,2) DEFAULT '0.00',
  `revenue` decimal(40,2) DEFAULT '0.00',
  `Forwbal` decimal(40,2) DEFAULT '0.00',
  `Currbal` decimal(40,2) DEFAULT '0.00',
  `payment` decimal(40,2) DEFAULT '0.00',
  `currcharg` decimal(40,2) DEFAULT '0.00',
  `hperiod` varchar(50) DEFAULT '',
  `billno` varchar(30) DEFAULT '',
  `ctrlno` tinyint(10) DEFAULT '0',
  `isedit` tinyint(3) DEFAULT '0',
  `pleft` decimal(40,2) DEFAULT '0.00',
  `b00` decimal(40,2) DEFAULT '0.00',
  `b13` decimal(40,2) DEFAULT '0.00',
  `b36` decimal(40,2) DEFAULT '0.00',
  `b69` decimal(40,2) DEFAULT '0.00',
  `b99` decimal(40,2) DEFAULT '0.00',
  `penchrg` decimal(40,2) DEFAULT '0.00',
  `soaperiod` date DEFAULT NULL,
  `soaperiod2` date DEFAULT NULL,
  `isMerchant` int(5) DEFAULT '0',
  `Merchant_Code` varchar(10) DEFAULT '',
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `InquiryID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_TenantID` (`tenantid`(11)),
  KEY `soaperiod` (`soaperiod`),
  KEY `soaperiod2` (`soaperiod2`),
  KEY `billno` (`billno`(25))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: dunn_tblsoaheader_copy
CREATE TABLE `dunn_tblsoaheader_copy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `soaid` varchar(40) NOT NULL,
  `tenantid` varchar(40) DEFAULT NULL,
  `tenantname` text,
  `totalamount` double(40,6) DEFAULT '0.000000',
  `createdby` varchar(40) DEFAULT NULL,
  `datecreated` date DEFAULT NULL,
  `duedate` date DEFAULT NULL,
  `tenantdues` decimal(10,2) DEFAULT '0.00',
  `revenue` decimal(10,2) DEFAULT '0.00',
  `Forwbal` decimal(10,2) DEFAULT '0.00',
  `Currbal` decimal(10,2) DEFAULT '0.00',
  `payment` decimal(10,2) DEFAULT '0.00',
  `currcharg` decimal(10,2) DEFAULT '0.00',
  `hperiod` varchar(50) DEFAULT '',
  `billno` varchar(30) DEFAULT '',
  `ctrlno` tinyint(10) DEFAULT '0',
  `isedit` tinyint(3) DEFAULT '0',
  `pleft` decimal(10,2) DEFAULT '0.00',
  `b00` decimal(10,2) DEFAULT '0.00',
  `b13` decimal(10,2) DEFAULT '0.00',
  `b36` decimal(10,2) DEFAULT '0.00',
  `b69` decimal(10,2) DEFAULT '0.00',
  `b99` decimal(10,2) DEFAULT '0.00',
  `penchrg` decimal(10,2) DEFAULT '0.00',
  `soaperiod` date DEFAULT NULL,
  `soaperiod2` date DEFAULT NULL,
  `isMerchant` int(5) DEFAULT '0',
  `Merchant_Code` varchar(10) DEFAULT '',
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `IDX_TenantID` (`tenantid`(11)),
  KEY `soaperiod` (`soaperiod`),
  KEY `soaperiod2` (`soaperiod2`),
  KEY `billno` (`billno`(25))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: dunn_tblsoavacant
CREATE TABLE `dunn_tblsoavacant` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `vacsoa` decimal(10,0) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: emergency_details
CREATE TABLE `emergency_details` (
  `contactid` int(11) DEFAULT NULL,
  `contactname` varchar(50) DEFAULT NULL,
  `contactnum` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: emergency_header
CREATE TABLE `emergency_header` (
  `contactid` int(11) NOT NULL AUTO_INCREMENT,
  `contactname` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`contactid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: event_attachments
CREATE TABLE `event_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT '',
  `path` varchar(150) DEFAULT '',
  `ext` varchar(10) DEFAULT '',
  `eventid` varchar(30) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;


-- Table: event_dayactivity
CREATE TABLE `event_dayactivity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` varchar(30) DEFAULT '',
  `actTitle` varchar(150) DEFAULT '',
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `statdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;


-- Table: event_facilities
CREATE TABLE `event_facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` varchar(30) DEFAULT NULL,
  `facilityID` varchar(30) DEFAULT NULL,
  `facility` varchar(100) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `facilityUnit` varchar(100) DEFAULT NULL,
  `facilityRemarks` varchar(250) DEFAULT NULL,
  `facilityprice` decimal(10,4) DEFAULT '0.0000',
  `facilitytotal` decimal(10,4) DEFAULT '0.0000',
  `vat` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;


-- Table: event_header
CREATE TABLE `event_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` varchar(30) DEFAULT '',
  `inquiryid` varchar(30) DEFAULT '',
  `eventName` varchar(100) DEFAULT NULL,
  `eDate` date DEFAULT NULL,
  `eTime` time DEFAULT NULL,
  `compCode` varchar(30) DEFAULT NULL,
  `compName` varchar(100) DEFAULT NULL,
  `compAddress` varchar(250) DEFAULT NULL,
  `compTIN` varchar(30) DEFAULT NULL,
  `eOrganizer` varchar(50) DEFAULT '',
  `RevType` varchar(30) DEFAULT NULL,
  `userAdded` varchar(30) DEFAULT NULL,
  `dateAdded` date DEFAULT NULL,
  `x_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `confirmdate` date DEFAULT NULL,
  `notedbyid` varchar(30) DEFAULT NULL,
  `notedbyname` varchar(30) DEFAULT NULL,
  `proposalNum` varchar(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: event_manpower
CREATE TABLE `event_manpower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` varchar(30) DEFAULT NULL,
  `manpowercode` varchar(30) DEFAULT NULL,
  `manpower` varchar(100) DEFAULT NULL,
  `pax` int(5) DEFAULT NULL,
  `mprice` decimal(10,4) DEFAULT '0.0000',
  `totprice` decimal(10,4) DEFAULT '0.0000',
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `need` varchar(200) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  `mpstartdate` date DEFAULT NULL,
  `mpenddate` date DEFAULT NULL,
  `vat` decimal(10,4) DEFAULT '0.0000',
  `qty` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;


-- Table: event_organizer
CREATE TABLE `event_organizer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` varchar(30) DEFAULT NULL,
  `orgCode` varchar(30) DEFAULT '',
  `orgName` varchar(80) DEFAULT '',
  `orgQty` int(11) DEFAULT NULL,
  `orgUnit` varchar(30) DEFAULT '',
  `orgRemarks` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: event_paraphernalia
CREATE TABLE `event_paraphernalia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `maincode` varchar(20) DEFAULT NULL,
  `eventID` varchar(30) DEFAULT NULL,
  `pCode` varchar(30) DEFAULT NULL,
  `pName` varchar(100) DEFAULT NULL,
  `remarks` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: event_personnel
CREATE TABLE `event_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventID` varchar(30) DEFAULT NULL,
  `personCode` varchar(30) DEFAULT NULL,
  `personName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: event_promotional
CREATE TABLE `event_promotional` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` varchar(30) DEFAULT '',
  `promotionalid` varchar(30) DEFAULT '',
  `promotionaldesc` varchar(100) DEFAULT '',
  `remarks` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: event_requirements
CREATE TABLE `event_requirements` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` varchar(20) DEFAULT NULL,
  `reqid` varchar(20) DEFAULT NULL,
  `reqName` varchar(150) DEFAULT NULL,
  `imageName` varchar(100) DEFAULT NULL,
  `imageEx` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: event_soundsystem
CREATE TABLE `event_soundsystem` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eventid` varchar(30) DEFAULT NULL,
  `pCode` varchar(30) DEFAULT NULL,
  `pName` varchar(30) DEFAULT NULL,
  `pqty` int(5) DEFAULT NULL,
  `pprice` decimal(10,4) DEFAULT '0.0000',
  `ptotprice` decimal(10,4) DEFAULT '0.0000',
  `pstarttime` time DEFAULT NULL,
  `pendtime` time DEFAULT NULL,
  `pneeds` varchar(100) DEFAULT '',
  `premarks` varchar(200) DEFAULT NULL,
  `soundstartdate` date DEFAULT NULL,
  `soundenddate` date DEFAULT NULL,
  `vat` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;


-- Table: fdb_discount
CREATE TABLE `fdb_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(10) DEFAULT NULL,
  `fvcDscntCd` varchar(10) DEFAULT NULL,
  `fvcDscntPrcntg` decimal(20,4) DEFAULT NULL,
  `fnmDscnt` decimal(20,4) DEFAULT NULL,
  `fnmCntDcmnt` decimal(20,4) DEFAULT NULL,
  `fnmCntCstmr` decimal(20,4) DEFAULT NULL,
  `fnmCntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: fdb_not_paymenttypes
CREATE TABLE `fdb_not_paymenttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(20) DEFAULT NULL,
  `fvcPymntCd` varchar(20) DEFAULT NULL,
  `fvcPymntDsc` varchar(100) DEFAULT NULL,
  `fvcPymntCdCLSCd` varchar(20) DEFAULT NULL,
  `fvcPymntCdCLSDsc` varchar(100) DEFAULT NULL,
  `fnmPymnt` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: fdb_paymenttypes
CREATE TABLE `fdb_paymenttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(20) DEFAULT NULL,
  `fvcPymntCd` varchar(20) DEFAULT NULL,
  `fvcPymntDsc` varchar(100) DEFAULT NULL,
  `fvcPymntCdCLSCd` varchar(20) DEFAULT NULL,
  `fvcPymntCdCLSDsc` varchar(100) DEFAULT NULL,
  `fnmPymnt` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: fdb_perhour
CREATE TABLE `fdb_perhour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(10) DEFAULT NULL,
  `fvcHRLCd` time DEFAULT NULL,
  `fnmDlySls` decimal(20,4) DEFAULT NULL,
  `fnmCntDcmnt` decimal(20,4) DEFAULT NULL,
  `fnmCntCstmr` decimal(20,4) DEFAULT NULL,
  `fnmCntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: fdb_sales
CREATE TABLE `fdb_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(30) DEFAULT NULL,
  `tenantid` varchar(30) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(10) DEFAULT NULL,
  `fvcMrcntDsc` varchar(50) DEFAULT NULL,
  `fnmGrndTtlOld` decimal(20,4) DEFAULT NULL,
  `fnmGrndTtlNew` decimal(20,4) DEFAULT NULL,
  `fnmGTDlySls` decimal(20,4) DEFAULT NULL,
  `fnmGTDscnt` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntSNR` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntPWD` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntGPC` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntVIP` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntEMP` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntREG` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntOTH` decimal(20,4) DEFAULT NULL,
  `fnmGTRfnd` decimal(20,4) DEFAULT NULL,
  `fnmGTCncld` decimal(20,4) DEFAULT NULL,
  `fnmGTSlsVAT` decimal(20,4) DEFAULT NULL,
  `fnmGTVATSlsInclsv` decimal(20,4) DEFAULT NULL,
  `fnmGTVATSlsExclsv` decimal(20,4) DEFAULT NULL,
  `fnmOffclRcptBeg` decimal(20,4) DEFAULT NULL,
  `fnmOffclRcptEnd` decimal(20,4) DEFAULT NULL,
  `fnmGTCntDcmnt` decimal(20,4) DEFAULT NULL,
  `fnmGTCntCstmr` decimal(20,4) DEFAULT NULL,
  `fnmGTCntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `fnmGTLclTax` decimal(20,4) DEFAULT NULL,
  `fnmGTSrvcChrg` decimal(20,4) DEFAULT NULL,
  `fnmGTSlsNonVat` decimal(20,4) DEFAULT NULL,
  `fnmGTRwGrss` decimal(20,4) DEFAULT NULL,
  `fnmGTLclTaxDly` decimal(20,4) DEFAULT NULL,
  `fvcWrksttnNmbr` varchar(10) DEFAULT NULL,
  `fnmGTPymntCSH` decimal(20,4) DEFAULT NULL,
  `fnmGTPymntCRD` decimal(20,4) DEFAULT NULL,
  `fnmGTPymntOTH` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4226 DEFAULT CHARSET=latin1;


-- Table: fdb_salesbymn
CREATE TABLE `fdb_salesbymn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(30) DEFAULT NULL,
  `tenantid` varchar(30) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(10) DEFAULT NULL,
  `fvcMrcntDsc` varchar(50) DEFAULT NULL,
  `fnmGrndTtlOld` decimal(20,4) DEFAULT NULL,
  `fnmGrndTtlNew` decimal(20,4) DEFAULT NULL,
  `fnmGTDlySls` decimal(20,4) DEFAULT NULL,
  `fnmGTDscnt` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntSNR` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntPWD` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntGPC` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntVIP` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntEMP` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntREG` decimal(20,4) DEFAULT NULL,
  `fnmGTDscntOTH` decimal(20,4) DEFAULT NULL,
  `fnmGTRfnd` decimal(20,4) DEFAULT NULL,
  `fnmGTCncld` decimal(20,4) DEFAULT NULL,
  `fnmGTSlsVAT` decimal(20,4) DEFAULT NULL,
  `fnmGTVATSlsInclsv` decimal(20,4) DEFAULT NULL,
  `fnmGTVATSlsExclsv` decimal(20,4) DEFAULT NULL,
  `fnmOffclRcptBeg` decimal(20,4) DEFAULT NULL,
  `fnmOffclRcptEnd` decimal(20,4) DEFAULT NULL,
  `fnmGTCntDcmnt` decimal(20,4) DEFAULT NULL,
  `fnmGTCntCstmr` decimal(20,4) DEFAULT NULL,
  `fnmGTCntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `fnmGTLclTax` decimal(20,4) DEFAULT NULL,
  `fnmGTSrvcChrg` decimal(20,4) DEFAULT NULL,
  `fnmGTSlsNonVat` decimal(20,4) DEFAULT NULL,
  `fnmGTRwGrss` decimal(20,4) DEFAULT NULL,
  `fnmGTLclTaxDly` decimal(20,4) DEFAULT NULL,
  `fvcWrksttnNmbr` varchar(10) DEFAULT NULL,
  `fnmGTPymntCSH` decimal(20,4) DEFAULT NULL,
  `fnmGTPymntCRD` decimal(20,4) DEFAULT NULL,
  `fnmGTPymntOTH` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: fdb_void
CREATE TABLE `fdb_void` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `fdtTrnsctn` date DEFAULT NULL,
  `fvcMrchntCd` varchar(10) DEFAULT NULL,
  `fvcRfndCncldCd` varchar(10) DEFAULT NULL,
  `fvcRfndCncldRsn` varchar(100) DEFAULT NULL,
  `fnmAmt` decimal(20,2) DEFAULT NULL,
  `fnmCntDcmnt` decimal(20,2) DEFAULT NULL,
  `fnmCntCstmr` decimal(20,2) DEFAULT NULL,
  `fnmCntSnrCtzn` decimal(20,2) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_categories
CREATE TABLE `mall_directory_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoryid` varchar(20) DEFAULT NULL,
  `categoryname` varchar(200) DEFAULT NULL,
  `color` varchar(50) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_floors
CREATE TABLE `mall_directory_floors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `floorname` varchar(200) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `ext` varchar(20) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_other_coordinates
CREATE TABLE `mall_directory_other_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(202) DEFAULT NULL,
  `otherid` varchar(20) DEFAULT NULL,
  `coordid` varchar(20) DEFAULT NULL,
  `lat` varchar(100) DEFAULT NULL,
  `lon` varchar(100) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_others
CREATE TABLE `mall_directory_others` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `otherid` varchar(20) DEFAULT NULL,
  `othername` varchar(200) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_recordid
CREATE TABLE `mall_directory_recordid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(210) DEFAULT NULL,
  `lastid` varchar(20) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_route
CREATE TABLE `mall_directory_route` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `shopid` varchar(230) DEFAULT NULL,
  `routeid` varchar(20) DEFAULT NULL,
  `coord` text,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_shops
CREATE TABLE `mall_directory_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` varchar(20) DEFAULT NULL,
  `shopname` varchar(200) DEFAULT NULL,
  `categoryid` varchar(100) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_shops_coordinates
CREATE TABLE `mall_directory_shops_coordinates` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `categoryid` varchar(20) DEFAULT NULL,
  `shopid` varchar(20) DEFAULT NULL,
  `coordid` varchar(20) DEFAULT NULL,
  `coord` text,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_directory_top_searches
CREATE TABLE `mall_directory_top_searches` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shopid` varchar(20) DEFAULT NULL,
  `shopname` varchar(255) DEFAULT NULL,
  `ctr` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: mall_setup
CREATE TABLE `mall_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mall_id` varchar(200) NOT NULL,
  `prepby` varchar(200) NOT NULL DEFAULT '||',
  `chkdby` varchar(200) NOT NULL DEFAULT '||',
  `apprby` varchar(200) NOT NULL DEFAULT '||',
  `rcvdby` varchar(200) NOT NULL DEFAULT '||',
  `vatable_rent` varchar(5) NOT NULL DEFAULT 'yes',
  `vat_rent_type` varchar(5) NOT NULL DEFAULT 'inc',
  `vat_rent_prcnt` float NOT NULL DEFAULT '12',
  `vatable_penalty` varchar(5) NOT NULL DEFAULT 'yes',
  `vat_penalty_type` varchar(5) NOT NULL DEFAULT 'inc',
  `vat_penalty_prcnt` float unsigned NOT NULL DEFAULT '12',
  `penalty_type` varchar(20) NOT NULL DEFAULT 'percent',
  `penalty_percent` float NOT NULL DEFAULT '0',
  `penalty_amount` decimal(15,6) NOT NULL DEFAULT '0.000000',
  `associationdues` varchar(15) NOT NULL DEFAULT '0.000000',
  `depositperc` float NOT NULL DEFAULT '0',
  `spotperc` float DEFAULT '0',
  `downperc` float DEFAULT '0',
  `balanceperc` float DEFAULT '0',
  `promo_disc` float DEFAULT '0',
  `company_disc` float DEFAULT '0',
  `standard_disc` float DEFAULT '0',
  `reg_fee` float DEFAULT '0',
  `doc_tax` float DEFAULT '0',
  `trans_tax` float DEFAULT '0',
  `legal_fee` float DEFAULT '0',
  `WE_connection` float DEFAULT '0',
  `misc_fee` float DEFAULT '0',
  `typeofreservationfee` varchar(20) DEFAULT 'Amount',
  `reservationfee` float DEFAULT '0',
  `typeofretentionfee` varchar(20) DEFAULT 'Amount',
  `retentionfee` float DEFAULT '0',
  `eventsnotedbyid` varchar(30) DEFAULT NULL,
  `eventsnotedbyname` varchar(30) DEFAULT NULL,
  `MinElectric` decimal(30,4) DEFAULT '0.0000',
  `MinWater` decimal(30,4) DEFAULT '0.0000',
  `MinGas` decimal(30,4) DEFAULT '0.0000',
  `ConRen_Days` decimal(30,6) DEFAULT '0.000000',
  `SoAFooter` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;


-- Table: pmls_android_location_task
CREATE TABLE `pmls_android_location_task` (
  `task_id` int(11) NOT NULL AUTO_INCREMENT,
  `work_task_id` int(11) DEFAULT NULL,
  `location_id` int(11) DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_pause` smallint(6) DEFAULT NULL,
  `time_prestart` time DEFAULT NULL,
  `time_duration` varchar(10) DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_reffield
CREATE TABLE `pmls_android_reffield` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_name` varchar(500) NOT NULL,
  `field_status` varchar(10) DEFAULT NULL,
  `total_area` int(11) DEFAULT NULL,
  `floor_number` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_reflocation
CREATE TABLE `pmls_android_reflocation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `loc_type` varchar(50) DEFAULT NULL,
  `loc_name` varchar(200) DEFAULT NULL,
  `loc_statuc` varchar(50) DEFAULT NULL,
  `total_area` decimal(10,0) DEFAULT NULL,
  `floor_number` int(11) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_refroom
CREATE TABLE `pmls_android_refroom` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `property_id` int(11) DEFAULT NULL,
  `room_number` varchar(60) NOT NULL,
  `room_status` varchar(10) DEFAULT NULL,
  `total_area` varchar(20) DEFAULT NULL,
  `floor_number` varbinary(10) DEFAULT NULL,
  `ready_to_lease` varchar(10) DEFAULT NULL,
  `target_rent` varchar(60) DEFAULT NULL,
  `bathrooms` int(11) DEFAULT NULL,
  `deposit` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`room_number`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_reftask
CREATE TABLE `pmls_android_reftask` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` varchar(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_user
CREATE TABLE `pmls_android_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(50) DEFAULT NULL,
  `firstname` varchar(250) DEFAULT NULL,
  `middlename` varchar(250) DEFAULT NULL,
  `lastname` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `gender` varchar(100) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `usertype` varchar(250) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `password2` varchar(500) DEFAULT NULL,
  `passwordstr` varchar(200) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  `groupaccess` varchar(200) DEFAULT NULL,
  `branch` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_worker_task
CREATE TABLE `pmls_android_worker_task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_task_id` varchar(20) NOT NULL,
  `room_owner_id` varchar(30) DEFAULT NULL,
  `ownername` varchar(100) DEFAULT NULL,
  `building_id` varchar(50) NOT NULL,
  `floorid` varchar(30) DEFAULT NULL,
  `category_tenant` varchar(30) DEFAULT NULL,
  `category_management` varchar(30) DEFAULT NULL,
  `task_id` varchar(30) NOT NULL,
  `task_id_management` varchar(20) DEFAULT NULL,
  `lasttask_id` varchar(30) NOT NULL,
  `location_id` varchar(50) NOT NULL,
  `management_location` varchar(50) NOT NULL,
  `worker_id` varchar(30) NOT NULL,
  `worker_name` varchar(50) DEFAULT NULL,
  `remarks` text,
  `sched` date DEFAULT NULL,
  `timestart` time DEFAULT NULL,
  `startt` datetime DEFAULT NULL,
  `labor_exp` double(30,2) DEFAULT NULL,
  `material_exp` double(30,2) DEFAULT NULL,
  `xstat` varchar(10) DEFAULT 'Pending',
  `resched_status` varchar(10) DEFAULT NULL,
  `duration` varchar(10) DEFAULT '00:00:00',
  `complaint_seriesno` varchar(20) DEFAULT NULL,
  `UnitType` varchar(10) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: pmls_android_worker_task_history
CREATE TABLE `pmls_android_worker_task_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `staff_task_id` varchar(100) DEFAULT NULL,
  `room_owner_id` varchar(100) NOT NULL,
  `ownername` varchar(100) NOT NULL,
  `building_id` varchar(100) NOT NULL,
  `floorid` varchar(100) DEFAULT NULL,
  `category_tenant` varchar(100) DEFAULT NULL,
  `category_management` varchar(100) DEFAULT NULL,
  `task_id` varchar(100) DEFAULT NULL,
  `task_id_management` varchar(100) DEFAULT NULL,
  `lasttask_id` varchar(100) DEFAULT NULL,
  `location_id` varchar(100) DEFAULT NULL,
  `management_location` varchar(100) DEFAULT NULL,
  `worker_id` varchar(100) DEFAULT NULL,
  `worker_name` varchar(50) DEFAULT NULL,
  `remarks` text,
  `sched` date DEFAULT NULL,
  `startt` datetime DEFAULT NULL,
  `endt` datetime DEFAULT NULL,
  `duration` varchar(20) DEFAULT NULL,
  `tagstat` varchar(100) DEFAULT NULL,
  `labor_exp` varchar(100) DEFAULT NULL,
  `material_exp` varchar(100) NOT NULL,
  `kilowatt` varchar(100) DEFAULT NULL,
  `kilowatt_php` varchar(100) DEFAULT NULL,
  `cubic_meter` varchar(100) DEFAULT NULL,
  `cubic_php` varchar(100) DEFAULT NULL,
  `total_amount` varchar(100) DEFAULT NULL,
  `payment_stat` smallint(6) DEFAULT NULL,
  `cutoff` varchar(100) DEFAULT NULL,
  `duedate` varchar(100) DEFAULT NULL,
  `paymentstat` varchar(10) DEFAULT NULL,
  `img_bef_1` varchar(100) DEFAULT NULL,
  `img_bef_2` varchar(100) DEFAULT NULL,
  `img_bef_3` varchar(100) DEFAULT NULL,
  `img_aft_1` varchar(100) DEFAULT NULL,
  `img_aft_2` varchar(100) DEFAULT NULL,
  `img_aft_3` varchar(100) DEFAULT NULL,
  `xstat` varchar(10) DEFAULT 'Resolved',
  `charges_status` varchar(10) DEFAULT 'Not Posted',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: products
CREATE TABLE `products` (
  `productId` int(11) NOT NULL AUTO_INCREMENT,
  `productName` varchar(100) NOT NULL,
  `categoryId` int(11) DEFAULT NULL,
  PRIMARY KEY (`productId`),
  KEY `fk_category` (`categoryId`),
  CONSTRAINT `fk_category` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: ref_maintenancemain
CREATE TABLE `ref_maintenancemain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mainid` varchar(50) DEFAULT NULL,
  `xdesc` varchar(200) DEFAULT NULL,
  `NOTIF_DAYS` int(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: ref_maintenancemain_log
CREATE TABLE `ref_maintenancemain_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LIid` varchar(50) DEFAULT NULL,
  `mainid` varchar(255) DEFAULT NULL,
  `xtask` varchar(50) DEFAULT NULL,
  `xdesc` varchar(200) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xstat` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: ref_maintenancemain_sub
CREATE TABLE `ref_maintenancemain_sub` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mainid` varchar(255) DEFAULT NULL,
  `xtask` varchar(255) DEFAULT NULL,
  `xdesc` text,
  `xperiod` varchar(50) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xday` varchar(20) DEFAULT NULL,
  `xday_num` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: refrecordid
CREATE TABLE `refrecordid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(50) DEFAULT NULL,
  `lastid` varchar(20) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;


-- Table: refrecordid_mall
CREATE TABLE `refrecordid_mall` (
  `id` tinyint(11) NOT NULL AUTO_INCREMENT,
  `tablename` varchar(80) DEFAULT NULL,
  `lastid` varchar(20) DEFAULT NULL,
  `mallid` varchar(20) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- Table: sdb_discount
CREATE TABLE `sdb_discount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(10) DEFAULT NULL,
  `DscntCd` varchar(10) DEFAULT NULL,
  `DscntPrcntg` decimal(20,4) DEFAULT NULL,
  `Dscnt` decimal(20,4) DEFAULT NULL,
  `CntDcmnt` decimal(20,4) DEFAULT NULL,
  `CntCstmr` decimal(20,4) DEFAULT NULL,
  `CntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: sdb_not_paymenttypes
CREATE TABLE `sdb_not_paymenttypes` (
  `id` int(112) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(20) DEFAULT NULL,
  `PymntCd` varchar(20) DEFAULT NULL,
  `PymntDsc` varchar(100) DEFAULT NULL,
  `PymntCdCLSCd` varchar(20) DEFAULT NULL,
  `PymntCdCLSDsc` varchar(100) DEFAULT NULL,
  `Pymnt` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: sdb_paymenttypes
CREATE TABLE `sdb_paymenttypes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(20) DEFAULT NULL,
  `PymntCd` varchar(20) DEFAULT NULL,
  `PymntDsc` varchar(100) DEFAULT NULL,
  `PymntCdCLSCd` varchar(20) DEFAULT NULL,
  `PymntCdCLSDsc` varchar(100) DEFAULT NULL,
  `Pymnt` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: sdb_perhour
CREATE TABLE `sdb_perhour` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(10) DEFAULT NULL,
  `HRLCd` time DEFAULT NULL,
  `DlySls` decimal(20,4) DEFAULT NULL,
  `CntDcmnt` decimal(20,4) DEFAULT NULL,
  `CntCstmr` decimal(20,4) DEFAULT NULL,
  `CntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: sdb_sales
CREATE TABLE `sdb_sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(30) DEFAULT NULL,
  `tenantid` varchar(30) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(30) DEFAULT NULL,
  `MrcntDsc` varchar(50) DEFAULT NULL,
  `GrndTtlOld` decimal(20,4) DEFAULT NULL,
  `GrndTtlNew` decimal(20,4) DEFAULT NULL,
  `GTDlySls` decimal(20,4) DEFAULT NULL,
  `GTDscnt` decimal(20,4) DEFAULT NULL,
  `GTDscntSNR` decimal(20,4) DEFAULT NULL,
  `GTDscntPWD` decimal(20,4) DEFAULT NULL,
  `GTDscntGPC` decimal(20,4) DEFAULT NULL,
  `GTDscntVIP` decimal(20,4) DEFAULT NULL,
  `GTDscntEMP` decimal(20,4) DEFAULT NULL,
  `GTDscntREG` decimal(20,4) DEFAULT NULL,
  `GTDscntOTH` decimal(20,4) DEFAULT NULL,
  `GTRfnd` decimal(20,4) DEFAULT NULL,
  `GTCncld` decimal(20,4) DEFAULT NULL,
  `GTSlsVAT` decimal(20,4) DEFAULT NULL,
  `GTVATSlsInclsv` decimal(20,4) DEFAULT NULL,
  `GTVATSlsExclsv` decimal(20,4) DEFAULT NULL,
  `OffclRcptBeg` decimal(20,4) DEFAULT NULL,
  `OffclRcptEnd` decimal(20,4) DEFAULT NULL,
  `GTCntDcmnt` decimal(20,4) DEFAULT NULL,
  `GTCntCstmr` decimal(20,4) DEFAULT NULL,
  `GTCntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `GTLclTax` decimal(20,4) DEFAULT NULL,
  `GTSrvcChrg` decimal(20,4) DEFAULT NULL,
  `GTSlsNonVat` decimal(20,4) DEFAULT NULL,
  `GTRwGrss` decimal(20,4) DEFAULT NULL,
  `GTLclTaxDly` decimal(20,4) DEFAULT NULL,
  `WrksttnNmbr` varchar(30) DEFAULT NULL,
  `GTPymntCSH` decimal(20,4) DEFAULT NULL,
  `GTPymntCRD` decimal(20,4) DEFAULT NULL,
  `GTPymntOTH` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: sdb_salesbymn
CREATE TABLE `sdb_salesbymn` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(30) DEFAULT NULL,
  `tenantid` varchar(30) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(30) DEFAULT NULL,
  `MrcntDsc` varchar(50) DEFAULT NULL,
  `GrndTtlOld` decimal(20,4) DEFAULT NULL,
  `GrndTtlNew` decimal(20,4) DEFAULT NULL,
  `GTDlySls` decimal(20,4) DEFAULT NULL,
  `GTDscnt` decimal(20,4) DEFAULT NULL,
  `GTDscntSNR` decimal(20,4) DEFAULT NULL,
  `GTDscntPWD` decimal(20,4) DEFAULT NULL,
  `GTDscntGPC` decimal(20,4) DEFAULT NULL,
  `GTDscntVIP` decimal(20,4) DEFAULT NULL,
  `GTDscntEMP` decimal(20,4) DEFAULT NULL,
  `GTDscntREG` decimal(20,4) DEFAULT NULL,
  `GTDscntOTH` decimal(20,4) DEFAULT NULL,
  `GTRfnd` decimal(20,4) DEFAULT NULL,
  `GTCncld` decimal(20,4) DEFAULT NULL,
  `GTSlsVAT` decimal(20,4) DEFAULT NULL,
  `GTVATSlsInclsv` decimal(20,4) DEFAULT NULL,
  `GTVATSlsExclsv` decimal(20,4) DEFAULT NULL,
  `OffclRcptBeg` decimal(20,4) DEFAULT NULL,
  `OffclRcptEnd` decimal(20,4) DEFAULT NULL,
  `GTCntDcmnt` decimal(20,4) DEFAULT NULL,
  `GTCntCstmr` decimal(20,4) DEFAULT NULL,
  `GTCntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `GTLclTax` decimal(20,4) DEFAULT NULL,
  `GTSrvcChrg` decimal(20,4) DEFAULT NULL,
  `GTSlsNonVat` decimal(20,4) DEFAULT NULL,
  `GTRwGrss` decimal(20,4) DEFAULT NULL,
  `GTLclTaxDly` decimal(20,4) DEFAULT NULL,
  `WrksttnNmbr` varchar(30) DEFAULT NULL,
  `GTPymntCSH` decimal(20,4) DEFAULT NULL,
  `GTPymntCRD` decimal(20,4) DEFAULT NULL,
  `GTPymntOTH` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: sdb_void
CREATE TABLE `sdb_void` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallID` varchar(20) DEFAULT NULL,
  `tenantID` varchar(20) DEFAULT NULL,
  `DteTrnsctn` date DEFAULT NULL,
  `MrchntCd` varchar(10) DEFAULT NULL,
  `RfndCncldCd` varchar(20) DEFAULT NULL,
  `RfndCncldRsn` varchar(100) DEFAULT NULL,
  `Amt` decimal(20,4) DEFAULT NULL,
  `CntDcmnt` decimal(20,4) DEFAULT NULL,
  `CntCstmr` decimal(20,4) DEFAULT NULL,
  `CntSnrCtzn` decimal(20,4) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: setup_dateevic
CREATE TABLE `setup_dateevic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateid` varchar(60) DEFAULT NULL,
  `nummonth` varchar(60) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: taskheader
CREATE TABLE `taskheader` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `taskid` varchar(50) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbl_charges_detail
CREATE TABLE `tbl_charges_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charge_detail_id` varchar(20) DEFAULT NULL,
  `staff_task_id` varchar(20) DEFAULT NULL,
  `charge_type_id` varchar(20) DEFAULT NULL,
  `charge_amount` varchar(20) DEFAULT NULL,
  `remarks` text,
  `charge_status` varchar(20) DEFAULT 'Not Posted',
  `xquantity` varchar(10) DEFAULT NULL,
  `sched` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbl_day
CREATE TABLE `tbl_day` (
  `day_id` int(10) NOT NULL AUTO_INCREMENT,
  `day` int(30) DEFAULT NULL,
  PRIMARY KEY (`day_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbl_month
CREATE TABLE `tbl_month` (
  `month_id` int(10) NOT NULL AUTO_INCREMENT,
  `month` int(10) DEFAULT NULL,
  `monthname` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`month_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;


-- Table: tbl_tenantspayments
CREATE TABLE `tbl_tenantspayments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(30) DEFAULT '',
  `mallid` varchar(30) DEFAULT '',
  `storename` varchar(80) DEFAULT '',
  `companyname` varchar(80) DEFAULT '',
  `paymentdate` date DEFAULT NULL,
  `paymenttype` varchar(50) DEFAULT '',
  `orno` varchar(40) DEFAULT '',
  `amount` decimal(10,4) DEFAULT '0.0000',
  `reference` varchar(100) DEFAULT '',
  `xuser` varchar(30) DEFAULT '',
  `xdatetime` datetime DEFAULT NULL,
  `mallname` varchar(80) DEFAULT '',
  `xstat` int(1) DEFAULT '0',
  `balance` decimal(10,4) DEFAULT '0.0000',
  `description` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tbl_visitor
CREATE TABLE `tbl_visitor` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `TransID` varchar(30) DEFAULT NULL,
  `VisitorID` varchar(30) DEFAULT NULL,
  `VisitorName` varchar(100) DEFAULT NULL,
  `ContactNumber` varchar(30) DEFAULT NULL,
  `Address_Company` text,
  `PurposeOfVisit` text,
  `DateIn` date DEFAULT NULL,
  `TimeIn` time DEFAULT NULL,
  `DateOut` date DEFAULT NULL,
  `TimeOut` time DEFAULT NULL,
  `userid` varchar(30) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblaccreditation
CREATE TABLE `tblaccreditation` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `AccredID` varchar(20) DEFAULT NULL,
  `TenantID` varchar(20) DEFAULT NULL,
  `DateOfAccreditation` date DEFAULT NULL,
  `DateOfCertification` date DEFAULT NULL,
  `RetailPartnerName` varchar(50) DEFAULT NULL,
  `NameofPOSProvider` varchar(50) DEFAULT NULL,
  `SoftwareVersion` varchar(50) DEFAULT NULL,
  `OperatingSystem` varchar(50) DEFAULT NULL,
  `NumberofPOS` varchar(10) DEFAULT '0',
  `ServiceCharge` varchar(20) DEFAULT NULL,
  `LocalTax` varchar(20) DEFAULT NULL,
  `NatureOfPos` varchar(50) DEFAULT NULL,
  `TextfileGeneration` varchar(30) DEFAULT NULL,
  `Remarks` text,
  `MobileNo` text,
  `TelephoneNo` text,
  `AuthorizedRepresentatives` text,
  `AccreditorsRepresentatives` text,
  `MachineNo` text,
  `PaymentType` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tblaccreditationdocs
CREATE TABLE `tblaccreditationdocs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AccredID` varchar(20) DEFAULT NULL,
  `AccredLogsID` varchar(20) DEFAULT NULL,
  `DocumentName` text,
  `FileType` varchar(20) DEFAULT NULL,
  `FileExt` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblaccreditationlogs
CREATE TABLE `tblaccreditationlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AccredID` varchar(20) DEFAULT NULL,
  `AccredLogsID` varchar(20) DEFAULT NULL,
  `AccredLogsDate` date DEFAULT NULL,
  `AccredLogsTime` time DEFAULT NULL,
  `AccredLogsResult` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tblasset_maintenance_d
CREATE TABLE `tblasset_maintenance_d` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `JONumber` varchar(40) DEFAULT NULL,
  `ExpenseDate` date DEFAULT NULL,
  `ExpenseType` text,
  `ExpenseQty` decimal(40,6) DEFAULT '0.000000',
  `ExpenseAmount` decimal(40,6) DEFAULT '0.000000',
  `ExpenseOR` varchar(40) DEFAULT NULL,
  `ExpenseRemarks` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblasset_maintenance_h
CREATE TABLE `tblasset_maintenance_h` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AssetNo` varchar(20) DEFAULT NULL,
  `JONumber` varchar(40) DEFAULT NULL,
  `JODate` date DEFAULT NULL,
  `JOStatus` varchar(20) DEFAULT NULL,
  `ItemCondition` varchar(30) DEFAULT NULL,
  `AssignedPerson` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblchat_header
CREATE TABLE `tblchat_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_userid` varchar(20) DEFAULT NULL,
  `receiver_userid` varchar(20) DEFAULT NULL,
  `messageid` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblchat_log
CREATE TABLE `tblchat_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messageid` varchar(20) DEFAULT NULL,
  `message` text,
  `sender_id` varchar(20) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblchat_record
CREATE TABLE `tblchat_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) DEFAULT NULL,
  `messageid` varchar(20) DEFAULT NULL,
  `xdatetime` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblcomplaints
CREATE TABLE `tblcomplaints` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(30) DEFAULT NULL,
  `Date_Entry` date DEFAULT NULL,
  `Complaint_Series_No` varchar(40) DEFAULT NULL,
  `Complaint_Code` varchar(40) DEFAULT NULL,
  `Complete_Description` text,
  `TradeName` varchar(80) DEFAULT NULL,
  `MallID` varchar(30) DEFAULT NULL,
  `WingID` varchar(30) DEFAULT NULL,
  `FloorID` varchar(30) DEFAULT NULL,
  `UnitID` varchar(30) DEFAULT NULL,
  `Time_Received` datetime DEFAULT CURRENT_TIMESTAMP,
  `Time_Resolved` datetime DEFAULT NULL,
  `Duration` varchar(30) DEFAULT NULL,
  `Complaint_Status` varchar(20) DEFAULT 'Pending',
  `Priority_Status` varchar(15) DEFAULT NULL,
  `UserID` varchar(30) DEFAULT NULL,
  `xdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Resolvedby` varbinary(30) DEFAULT NULL,
  `Remarks` text,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `IDX_Complaint_Code` (`Complaint_Code`(20)),
  KEY `IDX_Complaint_Description` (`Complete_Description`(50)),
  KEY `IDX_Complaint_Series_No` (`Complaint_Series_No`(10)),
  KEY `IDX_Complaint_Status` (`Complaint_Status`),
  KEY `IDX_Priority_Status` (`Priority_Status`),
  KEY `IDX_TenantID` (`TenantID`(20))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblcomplaintscode
CREATE TABLE `tblcomplaintscode` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Complaints_Code` varchar(50) DEFAULT NULL,
  `Complete_Description` text,
  `Priority_Status` varchar(30) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


-- Table: tblcondition
CREATE TABLE `tblcondition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Term_ID` varchar(30) DEFAULT NULL,
  `Term_Name` varchar(200) DEFAULT NULL,
  `Description` mediumtext,
  `Group_ID` varchar(100) DEFAULT NULL,
  `Group_Name` varchar(100) DEFAULT NULL,
  `Stats` int(30) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tblcontract
CREATE TABLE `tblcontract` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `ContractID` varchar(30) DEFAULT NULL,
  `MallID` varchar(30) DEFAULT NULL,
  `InquiryID` varchar(30) DEFAULT NULL,
  `TenantID` varchar(30) DEFAULT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `doesunitchange` tinyint(5) DEFAULT '0',
  `unitid` varchar(30) DEFAULT NULL,
  `newunitid` varchar(30) DEFAULT NULL,
  `Group_Name` mediumtext,
  `Term_Name` mediumtext,
  `Conditions` mediumtext,
  `ids` mediumtext,
  `appr_id1` varchar(20) DEFAULT NULL,
  `appr_user1` varchar(80) DEFAULT NULL,
  `appr_date1` datetime DEFAULT NULL,
  `appr_id2` varchar(20) DEFAULT NULL,
  `appr_user2` varchar(80) DEFAULT NULL,
  `appr_date2` datetime DEFAULT NULL,
  `ContractStat` varchar(10) DEFAULT NULL,
  `1st_app` varchar(20) DEFAULT '',
  `1st_date` datetime DEFAULT NULL,
  `1st_marks` varchar(200) DEFAULT '',
  `2nd_app` varchar(20) DEFAULT '',
  `2nd_date` datetime DEFAULT NULL,
  `2nd_marks` varchar(200) DEFAULT '',
  `3rd_app` varchar(20) DEFAULT '',
  `3rd_date` datetime DEFAULT NULL,
  `3rd_marks` varchar(200) DEFAULT '',
  `date_created` date DEFAULT NULL,
  `created_by` varchar(20) DEFAULT NULL,
  `AmendStat` varchar(20) DEFAULT 'Not Posted',
  `ProposalNum` tinyint(3) DEFAULT NULL,
  `isDirect` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `tblcontract_ibfk_1` (`InquiryID`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=latin1;


-- Table: tblforzreading
CREATE TABLE `tblforzreading` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Zreading` tinyint(5) DEFAULT '0',
  `Zreadingstat` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblgroups
CREATE TABLE `tblgroups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Group_ID` varchar(30) NOT NULL,
  `Group_Name` varchar(100) DEFAULT NULL,
  `Status` varchar(1) DEFAULT '1',
  PRIMARY KEY (`Group_ID`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbllog_sheet
CREATE TABLE `tbllog_sheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logID` varchar(30) DEFAULT NULL,
  `userid` varchar(30) DEFAULT NULL,
  `usertype` varchar(30) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `action` varchar(30) DEFAULT NULL,
  `Machine_No` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2064 DEFAULT CHARSET=latin1;


-- Table: tblloggedmachine
CREATE TABLE `tblloggedmachine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Machine_No` varchar(30) DEFAULT NULL,
  `Trans_No` varchar(30) DEFAULT NULL,
  `userid` varchar(30) DEFAULT NULL,
  `xdatein` datetime DEFAULT NULL,
  `xdateout` datetime DEFAULT NULL,
  `Onprocess` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbllogs_per_trans
CREATE TABLE `tbllogs_per_trans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mainID` varchar(30) DEFAULT NULL,
  `logID` varchar(30) DEFAULT NULL,
  `userid` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `mydate` date DEFAULT NULL,
  `mytime` time DEFAULT NULL,
  `remarks` text,
  `module` varchar(30) DEFAULT NULL,
  `xinfo` text,
  `xattach` text,
  `xaction` tinytext,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3219 DEFAULT CHARSET=latin1;


-- Table: tbllogs_zaputility
CREATE TABLE `tbllogs_zaputility` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `logID` varchar(30) DEFAULT NULL,
  `userid` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `mydate` date DEFAULT NULL,
  `mytime` time DEFAULT NULL,
  `xinfo` text,
  `xmodule` varchar(30) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmachine
CREATE TABLE `tblmachine` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Machine_No` varchar(30) DEFAULT NULL,
  `xstat` varchar(30) DEFAULT NULL,
  `Trans_No` varchar(30) DEFAULT NULL,
  `Onprocess` tinyint(5) DEFAULT '0',
  `androidDevice` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_category
CREATE TABLE `tblmaintenance_category` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `category_id` varchar(20) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `Maintenance_Type` varchar(20) DEFAULT NULL,
  `icon` text,
  `isFixed` varchar(10) DEFAULT NULL,
  `FixedAmount` double(40,2) DEFAULT '0.00',
  `AddTask` varchar(10) DEFAULT NULL,
  `isReading` tinyint(5) DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_charges
CREATE TABLE `tblmaintenance_charges` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `maintenance_details` varchar(50) DEFAULT NULL,
  `charge_amount` varchar(20) DEFAULT NULL,
  `charge_status` varchar(20) DEFAULT 'NOT POSTED',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_department
CREATE TABLE `tblmaintenance_department` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_equip
CREATE TABLE `tblmaintenance_equip` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(30) DEFAULT NULL,
  `description` varchar(30) DEFAULT NULL,
  `floor` varchar(30) DEFAULT NULL,
  `unit` varchar(30) DEFAULT NULL,
  `status` varchar(30) DEFAULT NULL,
  `xcategory` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_houserules
CREATE TABLE `tblmaintenance_houserules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Code` varchar(30) DEFAULT NULL,
  `Violation` varchar(255) DEFAULT NULL,
  `1st_offense` varchar(255) DEFAULT NULL,
  `2nd_offense` varchar(255) DEFAULT NULL,
  `2ndFine` decimal(15,4) DEFAULT NULL,
  `2ndwithVat` tinyint(1) DEFAULT '0',
  `2ndVat` decimal(15,4) DEFAULT NULL,
  `3rd_offense` varchar(255) DEFAULT NULL,
  `3rdFine` decimal(15,4) DEFAULT NULL,
  `3rdwithVat` tinyint(1) DEFAULT '0',
  `3rdVat` decimal(15,4) DEFAULT NULL,
  `xsucceeding` varchar(255) DEFAULT NULL,
  `sucFine` decimal(15,4) DEFAULT NULL,
  `sucwithVat` tinyint(1) DEFAULT '0',
  `sucVat` decimal(15,4) DEFAULT NULL,
  `1stFine` decimal(15,4) DEFAULT NULL,
  `1stwithVat` tinyint(1) DEFAULT '0',
  `1stVat` decimal(15,4) DEFAULT NULL,
  `JDA_Violation_Code` varchar(30) DEFAULT NULL,
  `Dr_COA` varchar(30) DEFAULT NULL,
  `Cr_COA` varchar(30) DEFAULT NULL,
  `LssrMjr` varchar(30) DEFAULT NULL,
  `LssrMnr` varchar(30) DEFAULT NULL,
  `LssrCOAStore` varchar(30) DEFAULT NULL,
  `VndrMjr` varchar(30) DEFAULT NULL,
  `VndrMnr` varchar(30) DEFAULT NULL,
  `VndrCOAStore` varchar(30) DEFAULT NULL,
  `WthTaxRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolatorremarks
CREATE TABLE `tblmaintenance_hrviolatorremarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RemarksCode` varchar(20) DEFAULT NULL,
  `VSeriesNumber` varchar(20) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `xdatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolatorremarks_attachment
CREATE TABLE `tblmaintenance_hrviolatorremarks_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RemarksCode` varchar(20) DEFAULT NULL,
  `FileName` varchar(255) DEFAULT NULL,
  `FileType` varchar(255) DEFAULT NULL,
  `FileType2` varchar(20) DEFAULT NULL,
  `VSeriesNumber` varchar(20) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `xdatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolators
CREATE TABLE `tblmaintenance_hrviolators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VSeriesNumber` varchar(30) DEFAULT NULL,
  `Code` varchar(30) DEFAULT NULL,
  `Violation` varchar(255) DEFAULT NULL,
  `Resolution` text,
  `Remarks` text,
  `ViolatorID` varchar(30) DEFAULT NULL,
  `ViolatorName` varbinary(50) DEFAULT NULL,
  `offensetype` varchar(30) DEFAULT NULL,
  `xtype` varchar(30) DEFAULT NULL,
  `xstatus` varchar(30) DEFAULT 'Pending',
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xfine` varchar(50) DEFAULT NULL,
  `fine` decimal(15,4) DEFAULT '0.0000',
  `xvat` decimal(15,4) DEFAULT '0.0000',
  `totalAmount` decimal(15,4) DEFAULT '0.0000',
  `xdateresolved` date DEFAULT NULL,
  `xtimeresolved` time DEFAULT NULL,
  `xdatetimeresolved` datetime NOT NULL,
  `postingDate` date DEFAULT NULL,
  `postingTime` time DEFAULT NULL,
  PRIMARY KEY (`id`,`xdatetimeresolved`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolators_copy
CREATE TABLE `tblmaintenance_hrviolators_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VSeriesNumber` varchar(30) DEFAULT NULL,
  `Code` varchar(30) DEFAULT NULL,
  `Violation` varchar(255) DEFAULT NULL,
  `Resolution` text,
  `Remarks` text,
  `ViolatorID` varchar(30) DEFAULT NULL,
  `ViolatorName` varbinary(50) DEFAULT NULL,
  `offensetype` varchar(30) DEFAULT NULL,
  `xtype` varchar(30) DEFAULT NULL,
  `xstatus` varchar(30) DEFAULT 'Pending',
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xfine` varchar(50) DEFAULT NULL,
  `fine` decimal(15,4) DEFAULT '0.0000',
  `xvat` decimal(15,4) DEFAULT '0.0000',
  `totalAmount` decimal(15,4) DEFAULT '0.0000',
  `xdateresolved` date DEFAULT NULL,
  `xtimeresolved` time DEFAULT NULL,
  `xdatetimeresolved` datetime NOT NULL,
  `postingDate` date DEFAULT NULL,
  `postingTime` time DEFAULT NULL,
  PRIMARY KEY (`id`,`xdatetimeresolved`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolatorsheader
CREATE TABLE `tblmaintenance_hrviolatorsheader` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VSeriesNumber` varchar(30) DEFAULT NULL,
  `ViolatorID` varchar(30) DEFAULT NULL,
  `ViolatorName` varchar(50) DEFAULT NULL,
  `xstatus` varchar(20) DEFAULT 'Pending',
  `xtype` varbinary(20) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xdateresolved` date DEFAULT NULL,
  `xtimeresolved` time DEFAULT NULL,
  `xdatetimeresolved` datetime DEFAULT NULL,
  `mallid` varchar(30) DEFAULT NULL,
  `isPosted` int(11) DEFAULT '0',
  `addedBy` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolatorsheader_copy
CREATE TABLE `tblmaintenance_hrviolatorsheader_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `VSeriesNumber` varchar(30) DEFAULT NULL,
  `ViolatorID` varchar(30) DEFAULT NULL,
  `ViolatorName` varchar(50) DEFAULT NULL,
  `xstatus` varchar(20) DEFAULT 'Pending',
  `xtype` varbinary(20) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `xdateresolved` date DEFAULT NULL,
  `xtimeresolved` time DEFAULT NULL,
  `xdatetimeresolved` datetime DEFAULT NULL,
  `mallid` varchar(30) DEFAULT NULL,
  `isPosted` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolatorsresponse
CREATE TABLE `tblmaintenance_hrviolatorsresponse` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ResponseCode` varchar(20) DEFAULT NULL,
  `VSeriesNumber` varchar(20) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `Resolution` varchar(255) DEFAULT NULL,
  `xdatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_hrviolatorsresponse_attachment
CREATE TABLE `tblmaintenance_hrviolatorsresponse_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ResponseCode` varchar(20) DEFAULT NULL,
  `FileName` varchar(255) DEFAULT NULL,
  `FileType` varchar(255) DEFAULT NULL,
  `FileType2` varchar(20) DEFAULT NULL,
  `VSeriesNumber` varchar(20) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `xdatetime` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_management
CREATE TABLE `tblmaintenance_management` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `managementid` varchar(30) NOT NULL,
  `type` varchar(50) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `floor_located` varchar(30) DEFAULT NULL,
  `building_located` varchar(30) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'vacant',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_setup
CREATE TABLE `tblmaintenance_setup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `maintenance_setup` varchar(50) DEFAULT NULL,
  `per_amount` varchar(20) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_tasklist
CREATE TABLE `tblmaintenance_tasklist` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `xcategory` varchar(30) DEFAULT NULL,
  `taskid` varchar(30) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `amount` decimal(20,4) DEFAULT NULL,
  `equipmentname` varchar(100) DEFAULT NULL,
  `equipmentid` varchar(30) DEFAULT NULL,
  `LssrMjr` varchar(30) DEFAULT NULL,
  `LssrMnr` varchar(30) DEFAULT NULL,
  `LssrCOAStore` varchar(30) DEFAULT NULL,
  `VndrMjr` varchar(30) DEFAULT NULL,
  `VndrMnr` varchar(30) DEFAULT NULL,
  `VndrCOAStore` varchar(30) DEFAULT NULL,
  `WthTaxRate` decimal(30,4) DEFAULT '0.0000',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_workorder
CREATE TABLE `tblmaintenance_workorder` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `workorderid` varchar(30) DEFAULT NULL,
  `TenantID` varchar(30) DEFAULT NULL,
  `ownername` varchar(80) DEFAULT NULL,
  `tradename` varchar(80) DEFAULT NULL,
  `joformanagement` varchar(30) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `workerid` varchar(255) DEFAULT NULL,
  `workername` varchar(50) DEFAULT NULL,
  `remarks` text,
  `xstatus` varchar(30) DEFAULT 'Pending',
  `postingstatus` varchar(30) DEFAULT 'Not Posted',
  `dateposted` date DEFAULT NULL,
  `xdateandtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `startdate` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `starttime` time DEFAULT NULL,
  `endtime` time DEFAULT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `Complaint_Series_No` varchar(30) DEFAULT NULL,
  `totalamount` varchar(50) DEFAULT NULL,
  `departmentid` varchar(30) DEFAULT NULL,
  `mallid` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=699 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_workorderlist
CREATE TABLE `tblmaintenance_workorderlist` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `workorderid` varchar(30) DEFAULT '',
  `tenantid` varchar(30) DEFAULT '',
  `xcategory` varchar(30) DEFAULT '',
  `xtaskid` varchar(30) DEFAULT '',
  `taskstatus` varchar(30) DEFAULT 'Pending',
  `xstatus` varchar(30) DEFAULT 'Not Posted',
  `dateposted` date DEFAULT NULL,
  `schedline` text,
  `schedduration` varchar(20) DEFAULT '0',
  `MeterID` varchar(50) DEFAULT NULL,
  `Multiplier` decimal(10,5) DEFAULT NULL,
  `CurrentMeterUsage` decimal(30,6) DEFAULT '0.000000',
  `UsageStartDate` date DEFAULT NULL,
  `meter_reading` decimal(30,6) DEFAULT '0.000000',
  `amount` decimal(30,6) DEFAULT '0.000000',
  `sub_total` decimal(30,6) DEFAULT '0.000000',
  `admin_fee` decimal(30,6) DEFAULT '0.000000',
  `vat_amount` decimal(30,6) DEFAULT '0.000000',
  `total_amount` decimal(30,6) DEFAULT '0.000000',
  `meter_img` varchar(100) DEFAULT '',
  `reading_date` date DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `signature` varchar(100) DEFAULT NULL,
  `comment` text,
  `InquiryID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=764 DEFAULT CHARSET=latin1;


-- Table: tblmaintenance_workorderlist_copy
CREATE TABLE `tblmaintenance_workorderlist_copy` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `workorderid` varchar(30) DEFAULT '',
  `tenantid` varchar(30) DEFAULT '',
  `xcategory` varchar(30) DEFAULT '',
  `xtaskid` varchar(30) DEFAULT '',
  `taskstatus` varchar(30) DEFAULT 'Pending',
  `xstatus` varchar(30) DEFAULT 'Not Posted',
  `dateposted` date DEFAULT NULL,
  `schedline` text,
  `schedduration` varchar(20) DEFAULT '0',
  `MeterID` varchar(50) DEFAULT NULL,
  `CurrentMeterUsage` decimal(40,4) DEFAULT '0.0000',
  `UsageStartDate` date DEFAULT NULL,
  `meter_reading` decimal(40,4) DEFAULT '0.0000',
  `sub_total` decimal(20,4) DEFAULT '0.0000',
  `meter_img` varchar(100) DEFAULT '',
  `reading_date` date DEFAULT NULL,
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `signature` varchar(100) DEFAULT NULL,
  `comment` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=latin1;


-- Table: tblref_amenities
CREATE TABLE `tblref_amenities` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `amenitiesid` varchar(50) DEFAULT NULL,
  `amenitiesname` varchar(50) DEFAULT NULL,
  `abbreviation` varchar(10) DEFAULT NULL,
  `qty` int(1) DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;


-- Table: tblref_applicationrequirements
CREATE TABLE `tblref_applicationrequirements` (
  `id` bigint(50) NOT NULL AUTO_INCREMENT,
  `reqCode` varchar(20) DEFAULT NULL,
  `requirements` varchar(100) DEFAULT NULL,
  `override` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;


-- Table: tblref_applicationrequirements2
CREATE TABLE `tblref_applicationrequirements2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `requirements` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_apprlist
CREATE TABLE `tblref_apprlist` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(50) DEFAULT NULL,
  `module` varchar(50) DEFAULT NULL,
  `personnel` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `level` int(20) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_apprlistperuser
CREATE TABLE `tblref_apprlistperuser` (
  `id` int(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(30) DEFAULT NULL,
  `code` varchar(50) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `designation` varchar(50) DEFAULT NULL,
  `level` int(20) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_asset
CREATE TABLE `tblref_asset` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `AssetNo` varchar(20) DEFAULT NULL,
  `AssetDesc` varchar(100) DEFAULT NULL,
  `AssetCategory` varchar(50) DEFAULT NULL,
  `AssetClass` varchar(50) DEFAULT NULL,
  `AssetBrand` varchar(100) DEFAULT NULL,
  `AssetColor` varchar(20) DEFAULT NULL,
  `AssetSerial` varchar(50) DEFAULT NULL,
  `AssetBarcode` varchar(50) DEFAULT NULL,
  `AssetSupplier` varchar(100) DEFAULT NULL,
  `AssetDimension` varchar(100) DEFAULT NULL,
  `AssetStatus` varchar(20) DEFAULT NULL,
  `AssetDepartment` varchar(50) DEFAULT NULL,
  `AssetHolder` varchar(100) DEFAULT NULL,
  `AssetLocation` varchar(100) DEFAULT NULL,
  `AssetQuantity` decimal(40,6) DEFAULT '0.000000',
  `AssetUnits` varchar(20) DEFAULT NULL,
  `AcquisitionAmount` decimal(40,6) DEFAULT '0.000000',
  `LifeInYears` varchar(20) DEFAULT NULL,
  `DepreciatedCost` decimal(40,6) DEFAULT '0.000000',
  `SalvageAmount` decimal(40,6) DEFAULT '0.000000',
  `ParentUnit` varchar(20) DEFAULT NULL,
  `AcqusitionDate` date DEFAULT NULL,
  `Ownership` varchar(40) DEFAULT NULL,
  `AssetImage` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_billperiod
CREATE TABLE `tblref_billperiod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soaid` varchar(20) DEFAULT NULL,
  `BillMonth` int(11) DEFAULT NULL,
  `BillYear` int(11) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Posted` int(5) DEFAULT '0',
  `Processed` int(5) DEFAULT '0',
  `MallID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DD` (`DueDate`),
  KEY `IDX_ED` (`EndDate`),
  KEY `IDX_SD` (`StartDate`),
  KEY `IDX_SOAID` (`soaid`)
) ENGINE=InnoDB AUTO_INCREMENT=253 DEFAULT CHARSET=latin1;


-- Table: tblref_billperiod_copy
CREATE TABLE `tblref_billperiod_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `soaid` varchar(20) DEFAULT NULL,
  `BillMonth` int(11) DEFAULT NULL,
  `BillYear` int(11) DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `Posted` int(5) DEFAULT '0',
  `Processed` int(5) DEFAULT '0',
  `MallID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_DD` (`DueDate`),
  KEY `IDX_ED` (`EndDate`),
  KEY `IDX_SD` (`StartDate`),
  KEY `IDX_SOAID` (`soaid`)
) ENGINE=InnoDB AUTO_INCREMENT=133 DEFAULT CHARSET=latin1;


-- Table: tblref_billprofile
CREATE TABLE `tblref_billprofile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `BillerID` varchar(30) NOT NULL,
  `BillerName` varchar(100) DEFAULT NULL,
  `Telephone` varchar(30) DEFAULT NULL,
  `Mobile` varchar(30) DEFAULT NULL,
  `Email` varchar(60) DEFAULT NULL,
  `PermanentAddress` varchar(255) DEFAULT NULL,
  `CurrentAddress` varchar(255) DEFAULT NULL,
  `BillingAddress` varchar(255) DEFAULT NULL,
  `MallID` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`BillerID`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=latin1;


-- Table: tblref_bldg
CREATE TABLE `tblref_bldg` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bldgnumber` varchar(60) DEFAULT NULL,
  `bldgtype` varchar(60) DEFAULT NULL,
  `bldgname` varchar(100) DEFAULT NULL,
  `bldgabb` varchar(60) DEFAULT NULL,
  `nooffloors` varchar(50) DEFAULT NULL,
  `noofrooms` varchar(50) DEFAULT NULL,
  `fulladdress` varchar(250) DEFAULT NULL,
  `description` varchar(300) DEFAULT NULL,
  `cutoffwater` varchar(50) DEFAULT NULL,
  `duedatewater` varchar(50) DEFAULT NULL,
  `cutoffelectricity` varchar(50) DEFAULT NULL,
  `duedateelectricity` varchar(50) DEFAULT NULL,
  `cubicrate` varchar(50) DEFAULT NULL,
  `kilowattrate` varchar(50) DEFAULT NULL,
  `address` varchar(60) DEFAULT NULL,
  `city` varchar(60) DEFAULT NULL,
  `province` varchar(60) DEFAULT NULL,
  `zipcode` varchar(60) DEFAULT NULL,
  `multiunit` varchar(5) DEFAULT NULL,
  `mallid` varchar(50) DEFAULT NULL,
  `mallname` varchar(100) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_brgy
CREATE TABLE `tblref_brgy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `brgyCode` varchar(255) DEFAULT NULL,
  `brgyDesc` text,
  `regCode` varchar(255) DEFAULT NULL,
  `provCode` varchar(255) DEFAULT NULL,
  `citymunCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `brgyDesc` (`brgyDesc`(10))
) ENGINE=MyISAM AUTO_INCREMENT=42030 DEFAULT CHARSET=utf8;


-- Table: tblref_budget
CREATE TABLE `tblref_budget` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(50) DEFAULT NULL,
  `category_id` varchar(30) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `xyear` year(4) DEFAULT NULL,
  `xjan` decimal(40,6) DEFAULT '0.000000',
  `xfeb` decimal(40,6) DEFAULT '0.000000',
  `xmar` decimal(40,6) DEFAULT '0.000000',
  `xapr` decimal(40,6) DEFAULT '0.000000',
  `xmay` decimal(40,6) DEFAULT '0.000000',
  `xjun` decimal(40,6) DEFAULT '0.000000',
  `xjul` decimal(40,6) DEFAULT '0.000000',
  `xaug` decimal(40,6) DEFAULT '0.000000',
  `xsep` decimal(40,6) DEFAULT '0.000000',
  `xoct` decimal(40,6) DEFAULT '0.000000',
  `xnov` decimal(40,6) DEFAULT '0.000000',
  `xdec` decimal(40,6) DEFAULT '0.000000',
  `xdateentry` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xdateupdate` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tblref_cardtype
CREATE TABLE `tblref_cardtype` (
  `CardType` varchar(50) DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_charges
CREATE TABLE `tblref_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `chrgid` varchar(20) DEFAULT '',
  `chrgname` varchar(100) DEFAULT '',
  `chrgamount` decimal(10,2) DEFAULT '0.00',
  `chrgpenaltytype` varchar(100) DEFAULT '',
  `chrgpenalpercent` int(10) DEFAULT '0',
  `chrgpealamount` decimal(10,4) DEFAULT NULL,
  `chrgpenalvatper` int(3) DEFAULT '0',
  `chrgpenalvatable` char(5) DEFAULT NULL,
  `chrgpenalvattype` char(5) DEFAULT NULL,
  `xdelete` int(1) DEFAULT '0',
  `xuser` varchar(20) DEFAULT '',
  `xdate` date DEFAULT NULL,
  `xdatetime` datetime DEFAULT NULL,
  `xcat` varchar(100) DEFAULT NULL,
  `chrgvatpercent` int(3) DEFAULT '0',
  `vatable` char(5) DEFAULT NULL,
  `vattype` char(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_charges_type
CREATE TABLE `tblref_charges_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `chargetypeid` varchar(30) NOT NULL,
  `chargeid` varchar(30) NOT NULL,
  `chargename` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_citymun
CREATE TABLE `tblref_citymun` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `psgcCode` varchar(255) DEFAULT NULL,
  `citymunDesc` text,
  `regDesc` varchar(255) DEFAULT NULL,
  `provCode` varchar(255) DEFAULT NULL,
  `citymunCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citymunDesc` (`citymunDesc`(8))
) ENGINE=MyISAM AUTO_INCREMENT=1648 DEFAULT CHARSET=utf8;


-- Table: tblref_citymun_copy
CREATE TABLE `tblref_citymun_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `psgcCode` varchar(255) DEFAULT NULL,
  `citymunDesc` text,
  `regDesc` varchar(255) DEFAULT NULL,
  `provCode` varchar(255) DEFAULT NULL,
  `citymunCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citymunDesc` (`citymunDesc`(10))
) ENGINE=MyISAM AUTO_INCREMENT=1648 DEFAULT CHARSET=utf8;


-- Table: tblref_classification
CREATE TABLE `tblref_classification` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `classificationid` varchar(50) DEFAULT NULL,
  `classname` varchar(100) DEFAULT NULL,
  `businesstype` varchar(100) DEFAULT NULL,
  `businessid` varchar(100) DEFAULT NULL,
  `counter` varchar(20) DEFAULT NULL,
  `pricepersqm` varchar(100) DEFAULT NULL,
  `sqm` varchar(100) DEFAULT NULL,
  `totalprice` varchar(100) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_companyposition
CREATE TABLE `tblref_companyposition` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EmpDepCode` varchar(20) DEFAULT NULL,
  `EmpPositionCode` varchar(20) DEFAULT NULL,
  `xposition` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;


-- Table: tblref_conbond
CREATE TABLE `tblref_conbond` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `filename` text,
  `filetype` varchar(20) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  `datestart` date DEFAULT NULL,
  `enddate` date DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_consologs
CREATE TABLE `tblref_consologs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `GenMonth` int(11) DEFAULT NULL,
  `GenYear` year(4) DEFAULT NULL,
  `GenUser` varchar(20) DEFAULT NULL,
  `GenType` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_contract
CREATE TABLE `tblref_contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `LType` varchar(20) DEFAULT NULL,
  `LCode` varchar(50) DEFAULT NULL,
  `LDesc` varchar(100) DEFAULT NULL,
  `LContent` mediumtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- Table: tblref_csv_upload
CREATE TABLE `tblref_csv_upload` (
  `mall` tinyint(1) DEFAULT '0',
  `category` tinyint(1) DEFAULT '0',
  `classifiction` tinyint(1) DEFAULT '0',
  `wing` tinyint(1) DEFAULT '0',
  `floorName` tinyint(1) DEFAULT '0',
  `floorSetup` tinyint(1) DEFAULT '0',
  `department` tinyint(1) DEFAULT '0',
  `industry` tinyint(1) DEFAULT '0',
  `amenities` tinyint(1) DEFAULT '0',
  `unit` tinyint(1) DEFAULT '0',
  `company` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_dbupdatelogs
CREATE TABLE `tblref_dbupdatelogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `IP_ADDRESS` varchar(50) DEFAULT NULL,
  `MAC_ADDRESS` varchar(50) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;


-- Table: tblref_employee
CREATE TABLE `tblref_employee` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(20) DEFAULT NULL,
  `Code` varchar(20) DEFAULT NULL,
  `Position` varchar(20) DEFAULT NULL,
  `First_Name` varchar(30) DEFAULT NULL,
  `Middle_Name` varchar(30) DEFAULT NULL,
  `Last_Name` varchar(30) DEFAULT NULL,
  `Department` varchar(100) DEFAULT NULL,
  `tenant_code` varchar(50) DEFAULT NULL,
  `xstatus` tinyint(1) DEFAULT NULL,
  `remarks` varchar(255) DEFAULT NULL,
  `ximageid` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_event_facilities
CREATE TABLE `tblref_event_facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `facilityID` varchar(30) DEFAULT '',
  `facility` varchar(80) DEFAULT '',
  `facilityUnit` varchar(30) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_event_funit
CREATE TABLE `tblref_event_funit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitname` varchar(80) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_event_manpower
CREATE TABLE `tblref_event_manpower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `manpowercode` varchar(30) DEFAULT NULL,
  `manpower` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_event_organizer
CREATE TABLE `tblref_event_organizer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `orgCode` varchar(30) DEFAULT '',
  `orgName` varchar(80) DEFAULT '',
  `orgUnit` varchar(30) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_event_paraphernalia
CREATE TABLE `tblref_event_paraphernalia` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pCode` varchar(30) DEFAULT NULL,
  `pName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_event_personnel
CREATE TABLE `tblref_event_personnel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `personCode` varchar(30) DEFAULT NULL,
  `personName` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_facilities
CREATE TABLE `tblref_facilities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `FacilitiesCode` varchar(20) DEFAULT NULL,
  `FacilitiesDesc` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;


-- Table: tblref_filters
CREATE TABLE `tblref_filters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `module` varchar(255) DEFAULT NULL,
  `checked_value` varchar(255) DEFAULT NULL,
  `filters` varchar(255) DEFAULT NULL,
  `datefilter` varchar(255) DEFAULT NULL,
  `bystat` varchar(255) DEFAULT NULL,
  `xcheck` varchar(255) DEFAULT NULL,
  `userid` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=latin1;


-- Table: tblref_floor_lca
CREATE TABLE `tblref_floor_lca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `minarea` float DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_floorsetup
CREATE TABLE `tblref_floorsetup` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `mallid` varchar(20) DEFAULT NULL,
  `wingid` varchar(20) DEFAULT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `photo` tinyint(1) DEFAULT '0',
  `ext` varchar(50) DEFAULT NULL,
  `width` decimal(40,6) DEFAULT '0.000000',
  `height` decimal(40,6) DEFAULT '0.000000',
  `width2` decimal(40,6) DEFAULT '0.000000',
  `length2` decimal(40,6) DEFAULT '0.000000',
  `minarea` decimal(40,6) DEFAULT '0.000000',
  `TLA` decimal(40,6) DEFAULT '0.000000',
  `GLA` decimal(40,6) DEFAULT '0.000000',
  `floorstat` int(5) DEFAULT '1',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;


-- Table: tblref_floorsetup_copy
CREATE TABLE `tblref_floorsetup_copy` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `mallid` varchar(20) DEFAULT NULL,
  `wingid` varchar(20) DEFAULT NULL,
  `floor` varchar(50) DEFAULT NULL,
  `photo` tinyint(1) DEFAULT '0',
  `ext` varchar(50) DEFAULT NULL,
  `width` decimal(40,6) DEFAULT '0.000000',
  `height` decimal(40,6) DEFAULT '0.000000',
  `width2` decimal(40,6) DEFAULT '0.000000',
  `length2` decimal(40,6) DEFAULT '0.000000',
  `minarea` decimal(40,6) DEFAULT '0.000000',
  `TLA` decimal(40,6) DEFAULT '0.000000',
  `GLA` decimal(40,6) DEFAULT '0.000000',
  `floorstat` int(5) DEFAULT '1',
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;


-- Table: tblref_flr
CREATE TABLE `tblref_flr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floor` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


-- Table: tblref_groupaccess
CREATE TABLE `tblref_groupaccess` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` varchar(20) DEFAULT NULL,
  `groupname` varchar(200) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=latin1;


-- Table: tblref_groupaccess2
CREATE TABLE `tblref_groupaccess2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `groupid` varchar(20) DEFAULT NULL,
  `groupname` varchar(200) DEFAULT NULL,
  `module` varchar(200) DEFAULT NULL,
  `addnew` varchar(100) DEFAULT NULL,
  `edit` varchar(100) DEFAULT NULL,
  `delremove` varchar(100) DEFAULT NULL,
  `approve` varchar(100) DEFAULT NULL,
  `eviction` varchar(100) DEFAULT NULL,
  `renewal` varchar(100) DEFAULT NULL,
  `pdc_clearing` varchar(100) DEFAULT NULL,
  `viewing` varchar(100) DEFAULT NULL,
  `post` varchar(100) DEFAULT NULL,
  `add2` varchar(100) DEFAULT NULL,
  `edit2` varchar(100) DEFAULT NULL,
  `delete2` varchar(100) DEFAULT NULL,
  `cost_of_repair` varchar(100) DEFAULT NULL,
  `payment` varchar(100) DEFAULT NULL,
  `soa` varchar(100) DEFAULT NULL,
  `user_access` varchar(100) DEFAULT NULL,
  `audit_trail` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_hardcodedid
CREATE TABLE `tblref_hardcodedid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `HC_ID` varchar(50) DEFAULT NULL,
  `HC_DESC` varchar(255) DEFAULT NULL,
  `xModule` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=latin1;


-- Table: tblref_industry
CREATE TABLE `tblref_industry` (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `Industry_ID` varchar(200) NOT NULL DEFAULT '',
  `Industry` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`Industry_ID`),
  UNIQUE KEY `idx_id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;


-- Table: tblref_investigator
CREATE TABLE `tblref_investigator` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `refbmid` varchar(200) DEFAULT NULL,
  `refbmlastname` varchar(250) DEFAULT NULL,
  `refbmfirstname` varchar(250) DEFAULT NULL,
  `refbmmiddlename` varchar(50) DEFAULT NULL,
  `refbmusername` varchar(50) DEFAULT NULL,
  `refbmpassword` varchar(50) DEFAULT NULL,
  `refbmposition` varchar(100) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_investigatorpos
CREATE TABLE `tblref_investigatorpos` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `investigatorpos` varchar(250) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_leasingsignatories
CREATE TABLE `tblref_leasingsignatories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) DEFAULT NULL,
  `mallid` varchar(20) DEFAULT NULL,
  `Signatory` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_location
CREATE TABLE `tblref_location` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `locationid` varchar(50) DEFAULT NULL,
  `buildingname` varchar(150) DEFAULT NULL,
  `completeaddress` text,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_maintenancetasksetup
CREATE TABLE `tblref_maintenancetasksetup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateofmonth` varchar(5) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_maintenancetasksetup_stat
CREATE TABLE `tblref_maintenancetasksetup_stat` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `refno` varchar(15) DEFAULT NULL,
  `TenantID` varchar(15) DEFAULT NULL,
  `task` varchar(20) DEFAULT NULL,
  `staff_task_id` varchar(15) DEFAULT NULL,
  `taskDate` date DEFAULT NULL,
  `stat` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_mall
CREATE TABLE `tblref_mall` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(50) NOT NULL DEFAULT '',
  `mallname` varchar(100) DEFAULT NULL,
  `malladdress` varchar(100) DEFAULT NULL,
  `abouts` text,
  `dateadded` date DEFAULT NULL,
  `mall_image` varchar(255) DEFAULT NULL,
  `telephone_number` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `mallstat` int(5) DEFAULT '1',
  `MaxLCA` int(10) DEFAULT '50',
  `MaxSET` int(10) DEFAULT '50',
  `tinnumber` varchar(50) DEFAULT NULL,
  `corp_ID` varchar(20) NOT NULL,
  `TenantIDPref` varchar(5) DEFAULT NULL,
  `JDAMall_Code` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`mallid`),
  UNIQUE KEY `id` (`id`),
  KEY `IDX_MallName` (`mallname`(10)),
  KEY `corp_ID` (`corp_ID`),
  CONSTRAINT `tblref_mall_ibfk_1` FOREIGN KEY (`corp_ID`) REFERENCES `tblref_mallcompany` (`MallCompanyID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;


-- Table: tblref_mall_addcharges
CREATE TABLE `tblref_mall_addcharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MallID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(20) DEFAULT NULL,
  `NoofMonths` int(11) DEFAULT NULL,
  `ChargeType` varchar(20) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_mallbankinfo
CREATE TABLE `tblref_mallbankinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(20) DEFAULT NULL,
  `bankcode` varchar(20) DEFAULT NULL,
  `bankdesc` varchar(40) DEFAULT NULL,
  `accountname` varchar(100) DEFAULT NULL,
  `accountnumber` varchar(30) DEFAULT NULL,
  `isShow` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- Table: tblref_mallcompany
CREATE TABLE `tblref_mallcompany` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MallCompanyID` varchar(20) NOT NULL,
  `MallCompanyName` varchar(100) DEFAULT NULL,
  `MallCompanyAbout` varchar(250) DEFAULT NULL,
  `MallCompanyMobile` varchar(20) DEFAULT NULL,
  `MallCompanyTelephone` varchar(20) DEFAULT NULL,
  `MallCompanyEmailAdd` varchar(50) DEFAULT NULL,
  `MallCompanyAddress` varchar(250) DEFAULT NULL,
  `MallCompanyImage` varchar(80) DEFAULT NULL,
  `datetimeadded` datetime DEFAULT NULL,
  `userid` varchar(20) DEFAULT NULL,
  `JDA_CompanyCode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`MallCompanyID`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `id_2` (`id`),
  UNIQUE KEY `id_3` (`id`),
  UNIQUE KEY `id_4` (`id`),
  UNIQUE KEY `id_5` (`id`),
  UNIQUE KEY `id_6` (`id`),
  UNIQUE KEY `id_7` (`id`),
  UNIQUE KEY `id_8` (`id`),
  UNIQUE KEY `id_9` (`id`),
  UNIQUE KEY `id_10` (`id`),
  UNIQUE KEY `id_11` (`id`),
  UNIQUE KEY `id_12` (`id`),
  UNIQUE KEY `id_13` (`id`),
  UNIQUE KEY `id_14` (`id`),
  UNIQUE KEY `id_15` (`id`),
  UNIQUE KEY `id_16` (`id`),
  UNIQUE KEY `id_17` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: tblref_manpower
CREATE TABLE `tblref_manpower` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ManpowerCode` varchar(20) DEFAULT NULL,
  `ManpowerDesc` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;


-- Table: tblref_merchandise_class
CREATE TABLE `tblref_merchandise_class` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `classificationID` varchar(100) NOT NULL DEFAULT '',
  `classification` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`classificationID`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- Table: tblref_merchandise_depa
CREATE TABLE `tblref_merchandise_depa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_ID` varchar(100) DEFAULT NULL,
  `departmentID` varchar(100) NOT NULL DEFAULT '',
  `department` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`departmentID`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_class` (`class_ID`),
  CONSTRAINT `fk_class` FOREIGN KEY (`class_ID`) REFERENCES `tblref_merchandise_class` (`classificationID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;


-- Table: tblref_merchandisedep_cat
CREATE TABLE `tblref_merchandisedep_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_ID` varchar(20) DEFAULT NULL,
  `dept_ID` varchar(100) DEFAULT NULL,
  `categoryID` varchar(100) NOT NULL DEFAULT '',
  `category` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`categoryID`),
  UNIQUE KEY `id` (`id`),
  KEY `fk_classID` (`class_ID`),
  KEY `fk_deptID` (`dept_ID`),
  CONSTRAINT `fk_classID` FOREIGN KEY (`class_ID`) REFERENCES `tblref_merchandise_class` (`classificationID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_deptID` FOREIGN KEY (`dept_ID`) REFERENCES `tblref_merchandise_depa` (`departmentID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;


-- Table: tblref_meter
CREATE TABLE `tblref_meter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentMeterID` varchar(50) DEFAULT NULL,
  `MeterID` varchar(50) DEFAULT NULL,
  `Multiplier` decimal(10,5) DEFAULT NULL,
  `MeterType` varchar(20) DEFAULT NULL,
  `AssignedTenant` varchar(20) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `xSub` tinyint(1) DEFAULT '0',
  `CurrentMeterUsage` decimal(40,6) DEFAULT '0.000000',
  `MeterStatus` tinyint(5) DEFAULT '1',
  `MallID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=240 DEFAULT CHARSET=latin1;


-- Table: tblref_meter_copy
CREATE TABLE `tblref_meter_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parentMeterID` varchar(50) DEFAULT NULL,
  `MeterID` varchar(50) DEFAULT NULL,
  `Multiplier` int(11) DEFAULT NULL,
  `MeterType` varchar(20) DEFAULT NULL,
  `AssignedTenant` varchar(20) DEFAULT NULL,
  `date_added` date DEFAULT NULL,
  `xSub` tinyint(1) DEFAULT '0',
  `CurrentMeterUsage` decimal(40,6) DEFAULT '0.000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_meterlogs
CREATE TABLE `tblref_meterlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MeterID` varchar(50) DEFAULT NULL,
  `Multiplier` decimal(10,5) DEFAULT NULL,
  `MeterType` varchar(20) DEFAULT NULL,
  `AssignedTenant` varchar(20) DEFAULT NULL,
  `SysDate` date DEFAULT NULL,
  `CurrentMeterUsage` decimal(40,6) DEFAULT '0.000000',
  `MallID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=664 DEFAULT CHARSET=latin1;


-- Table: tblref_meterlogs_copy
CREATE TABLE `tblref_meterlogs_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MeterID` varchar(50) DEFAULT NULL,
  `Multiplier` int(11) DEFAULT NULL,
  `MeterType` varchar(20) DEFAULT NULL,
  `AssignedTenant` varchar(20) DEFAULT NULL,
  `SysDate` date DEFAULT NULL,
  `CurrentMeterUsage` decimal(40,6) DEFAULT '0.000000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=304 DEFAULT CHARSET=latin1;


-- Table: tblref_msbilling
CREATE TABLE `tblref_msbilling` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MallID` varchar(20) DEFAULT NULL,
  `MonthlyRent` int(11) DEFAULT NULL,
  `OperationalCharges` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_msmaintenance_d
CREATE TABLE `tblref_msmaintenance_d` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SchedID` varchar(20) DEFAULT NULL,
  `xCategory` varchar(20) DEFAULT NULL,
  `xTask` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_msmaintenance_h
CREATE TABLE `tblref_msmaintenance_h` (
  `int` int(11) NOT NULL AUTO_INCREMENT,
  `SchedID` varchar(20) DEFAULT NULL,
  `mallID` varchar(20) DEFAULT NULL,
  `TenantID` varchar(20) DEFAULT NULL,
  `GroupAccess` varchar(20) DEFAULT NULL,
  `xPersonnel` varchar(255) DEFAULT NULL,
  `xPeriod` varchar(20) DEFAULT NULL,
  `xDOTW1` varchar(15) DEFAULT NULL,
  `xDOTW2` varchar(15) DEFAULT NULL,
  `xDOTM1` varchar(10) DEFAULT NULL,
  `xDOTM2` varchar(10) DEFAULT NULL,
  `FQ_Date1` date DEFAULT NULL,
  `FQ_Date2` date DEFAULT NULL,
  `SQ_Date1` date DEFAULT NULL,
  `SQ_Date2` date DEFAULT NULL,
  `TQ_Date1` date DEFAULT NULL,
  `TQ_Date2` date DEFAULT NULL,
  `LQ_Date1` date DEFAULT NULL,
  `LQ_Date2` date DEFAULT NULL,
  `xDateAdded` date DEFAULT NULL,
  `xTimeAdded` time DEFAULT NULL,
  `isAllTenant` tinyint(5) DEFAULT '0',
  `isAllPersonnel` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`int`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_operationalcharges
CREATE TABLE `tblref_operationalcharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CHARGE_DESC` varchar(20) DEFAULT NULL,
  `RATE_TYPE` varchar(20) DEFAULT NULL,
  `RATE` decimal(40,2) DEFAULT '0.00',
  `OTHER_REASON` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_organizerm
CREATE TABLE `tblref_organizerm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `OrganizermCode` varchar(20) DEFAULT NULL,
  `OrganizermDesc` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;


-- Table: tblref_paymentsched
CREATE TABLE `tblref_paymentsched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `PayDate` date DEFAULT NULL,
  `PayAmount` decimal(40,4) DEFAULT NULL,
  `RevPercentage` decimal(40,4) DEFAULT NULL,
  `PayAssocDues` decimal(40,4) DEFAULT NULL,
  `AdjPayAmount` decimal(40,4) DEFAULT NULL,
  `AdjRevPercentage` decimal(40,4) DEFAULT NULL,
  `AdjPayAssocDues` decimal(40,4) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_penalty
CREATE TABLE `tblref_penalty` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PenaltyCode` varchar(20) DEFAULT NULL,
  `PenaltyDesc` varchar(255) DEFAULT NULL,
  `Amount` decimal(30,6) DEFAULT '0.000000',
  `JDA_Penalty_Code` varchar(30) DEFAULT NULL,
  `Dr_COA` varchar(30) DEFAULT NULL,
  `Cr_COA` varchar(30) DEFAULT NULL,
  `LssrMjr` varchar(30) DEFAULT NULL,
  `LssrMnr` varchar(30) DEFAULT NULL,
  `LssrCOAStore` varchar(30) DEFAULT NULL,
  `VndrMjr` varchar(30) DEFAULT NULL,
  `VndrMnr` varchar(30) DEFAULT NULL,
  `VndrCOAStore` varchar(30) DEFAULT NULL,
  `WthTaxRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;


-- Table: tblref_pospaymenttype
CREATE TABLE `tblref_pospaymenttype` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `PaymentTypeID` varchar(50) DEFAULT NULL,
  `PaymentTypeDesc` varchar(50) DEFAULT NULL,
  `PaymentType` varchar(50) DEFAULT NULL,
  `JDA_Pay_Code` varchar(30) DEFAULT NULL,
  `Dr_COA` varchar(30) DEFAULT NULL,
  `Cr_COA` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;


-- Table: tblref_process_owner
CREATE TABLE `tblref_process_owner` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `deptCode` varchar(20) NOT NULL,
  `deptDesc` varchar(40) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`deptCode`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- Table: tblref_promotionalp
CREATE TABLE `tblref_promotionalp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PromotionalpCode` varchar(20) DEFAULT NULL,
  `PromotionalpDesc` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: tblref_province
CREATE TABLE `tblref_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `psgcCode` varchar(255) DEFAULT NULL,
  `provDesc` text,
  `regCode` varchar(255) DEFAULT NULL,
  `provCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=89 DEFAULT CHARSET=utf8;


-- Table: tblref_refcharges
CREATE TABLE `tblref_refcharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CHARGE_ID` varchar(20) DEFAULT NULL,
  `CHARGE_DESC` varchar(50) DEFAULT NULL,
  `CHARGE_TYPE` varchar(20) DEFAULT NULL,
  `RATE_TYPE` varchar(20) DEFAULT NULL,
  `RATE` decimal(40,2) DEFAULT '0.00',
  `OTHER_REASON` text,
  `isDefault` int(5) DEFAULT '0',
  `JDA_Charge_Code` varchar(30) DEFAULT NULL,
  `Dr_COA` varchar(30) DEFAULT NULL,
  `Cr_COA` varchar(30) DEFAULT NULL,
  `LssrMjr` varchar(30) DEFAULT NULL,
  `LssrMnr` varchar(30) DEFAULT NULL,
  `LssrCOAStore` varchar(30) DEFAULT NULL,
  `VndrMjr` varchar(30) DEFAULT NULL,
  `VndrMnr` varchar(30) DEFAULT NULL,
  `VndrCOAStore` varchar(30) DEFAULT NULL,
  `WthTaxRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;


-- Table: tblref_refcharges_copy
CREATE TABLE `tblref_refcharges_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CHARGE_ID` varchar(20) DEFAULT NULL,
  `CHARGE_DESC` varchar(50) DEFAULT NULL,
  `CHARGE_TYPE` varchar(20) DEFAULT NULL,
  `RATE_TYPE` varchar(20) DEFAULT NULL,
  `RATE` decimal(40,2) DEFAULT '0.00',
  `OTHER_REASON` text,
  `isDefault` int(5) DEFAULT '0',
  `JDA_Charge_Code` varchar(30) DEFAULT NULL,
  `Dr_COA` varchar(30) DEFAULT NULL,
  `Cr_COA` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;


-- Table: tblref_region
CREATE TABLE `tblref_region` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `psgcCode` varchar(255) DEFAULT NULL,
  `regDesc` text,
  `regCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;


-- Table: tblref_soundnper
CREATE TABLE `tblref_soundnper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `SoundnperCode` varchar(20) DEFAULT NULL,
  `SoundnperDesc` varchar(255) DEFAULT NULL,
  `Amount` decimal(10,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;


-- Table: tblref_source
CREATE TABLE `tblref_source` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `source_code` varchar(20) NOT NULL,
  `source_desc` varchar(40) DEFAULT NULL,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`source_code`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;


-- Table: tblref_sqm
CREATE TABLE `tblref_sqm` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `pricepersqm` varchar(10) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_tenantsdocs
CREATE TABLE `tblref_tenantsdocs` (
  `appID` varchar(20) DEFAULT NULL,
  `reqID` varchar(20) DEFAULT NULL,
  `documentid` varchar(20) DEFAULT NULL,
  `filename` text,
  `filetype` varchar(50) DEFAULT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `docname` text,
  `docdesc` text,
  `expirydate` date DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `proposalNum` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_type
CREATE TABLE `tblref_type` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `roomtypeid` varchar(50) DEFAULT NULL,
  `typename` varchar(150) DEFAULT NULL,
  `availability` varchar(50) DEFAULT NULL,
  `occupied` varchar(50) DEFAULT NULL,
  `classificationtype` varchar(200) DEFAULT NULL,
  `roomstatus` varchar(100) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_typeofbusiness
CREATE TABLE `tblref_typeofbusiness` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `businessid` varchar(50) DEFAULT NULL,
  `typeofbusiness` varchar(50) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_typeofpermits
CREATE TABLE `tblref_typeofpermits` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PermitCode` varchar(20) DEFAULT NULL,
  `DESCRIPTION` varchar(100) DEFAULT NULL,
  `override` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;


-- Table: tblref_unit
CREATE TABLE `tblref_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitid` varchar(50) DEFAULT NULL,
  `unitname` varchar(100) DEFAULT NULL,
  `buildingname` varchar(100) DEFAULT NULL,
  `typeofbusiness` varchar(100) DEFAULT NULL,
  `classificationname` varchar(100) DEFAULT NULL,
  `sqmunitsetup` varchar(100) DEFAULT NULL,
  `pricepersqmunitsetup` decimal(40,6) DEFAULT '0.000000',
  `totalamountunitsetup` decimal(40,6) DEFAULT '0.000000',
  `status` varchar(20) DEFAULT 'Vacant',
  `dateadded` date DEFAULT NULL,
  `mallid` varchar(20) DEFAULT NULL,
  `floorid` varchar(50) DEFAULT NULL,
  `wingid` varchar(50) DEFAULT NULL,
  `classid` varchar(50) DEFAULT NULL,
  `depid` varchar(50) DEFAULT NULL,
  `catid` varchar(50) DEFAULT NULL,
  `TenantID` varchar(50) DEFAULT NULL,
  `TenantName` varchar(50) DEFAULT NULL,
  `startDate` date DEFAULT NULL,
  `endDate` date DEFAULT NULL,
  `electricStat` tinyint(5) DEFAULT '0',
  `waterStat` tinyint(5) DEFAULT '0',
  `txtStat` tinyint(5) DEFAULT '0',
  `sqm_width` decimal(40,6) DEFAULT '0.000000',
  `sqm_height` decimal(40,6) DEFAULT '0.000000',
  `area` decimal(40,6) DEFAULT '0.000000',
  `max_num` int(11) DEFAULT '0',
  `rem_num` int(11) DEFAULT '0',
  `unitstat` int(5) DEFAULT '0',
  `assocdues` decimal(40,6) DEFAULT '0.000000',
  `photoext` varchar(10) DEFAULT NULL,
  `reserveDate` date DEFAULT NULL,
  `amenities` text,
  `MainUnit` varchar(20) DEFAULT NULL,
  `BillingSetup` varchar(20) DEFAULT NULL,
  `OtherUnitInfo` mediumtext,
  PRIMARY KEY (`id`),
  KEY `IDX_EndDate` (`endDate`),
  KEY `IDX_StartDate` (`startDate`),
  KEY `IDX_TenantID` (`TenantID`(10)),
  KEY `IDX_TenantName` (`TenantName`(10)),
  KEY `IDX_unitname` (`unitname`(10)),
  KEY `IDX_Category` (`catid`(10)),
  KEY `IDX_Classification` (`classificationname`(10)),
  KEY `IDX_Department` (`depid`(10)),
  KEY `IDX_FloorID` (`floorid`(10)),
  KEY `IDX_MallID` (`mallid`(10)),
  KEY `IDX_Status` (`status`(10)),
  KEY `IDX_WingID` (`wingid`(10)),
  KEY `id` (`unitid`)
) ENGINE=InnoDB AUTO_INCREMENT=276 DEFAULT CHARSET=latin1;


-- Table: tblref_unit_amenities
CREATE TABLE `tblref_unit_amenities` (
  `unitID` varchar(50) DEFAULT NULL,
  `unit` varchar(50) DEFAULT NULL,
  `amenitiesID` varchar(50) DEFAULT NULL,
  `amenities` varchar(70) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_unit_lca_dummy
CREATE TABLE `tblref_unit_lca_dummy` (
  `inquiryID` varchar(30) DEFAULT NULL,
  `appID` varchar(30) DEFAULT NULL,
  `UnitName` varchar(30) DEFAULT NULL,
  `width` varchar(30) DEFAULT NULL,
  `ulength` varchar(30) DEFAULT NULL,
  `amountpersqm` double(40,2) DEFAULT NULL,
  `totalamountsqm` double(40,2) DEFAULT NULL,
  `FlrName` varchar(30) DEFAULT NULL,
  `WingID` varchar(30) DEFAULT NULL,
  `MallID` varchar(30) DEFAULT NULL,
  `xStat` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_unitclass
CREATE TABLE `tblref_unitclass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UnitClassID` varchar(20) DEFAULT NULL,
  `UnitClassDesc` varchar(50) DEFAULT NULL,
  `dateadded` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;


-- Table: tblref_unitimage
CREATE TABLE `tblref_unitimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UnitID` varchar(20) DEFAULT NULL,
  `ImageName` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_unitlocated
CREATE TABLE `tblref_unitlocated` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `unitlocationid` varchar(50) DEFAULT NULL,
  `roomletter` varchar(20) DEFAULT NULL,
  `roomnumber` varchar(50) DEFAULT NULL,
  `locatedfloor` varchar(50) DEFAULT NULL,
  `sqm` varchar(50) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_unitplot
CREATE TABLE `tblref_unitplot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `unitid` varchar(20) DEFAULT NULL,
  `unitname` varchar(200) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `coord` text,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_unitplot2
CREATE TABLE `tblref_unitplot2` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `floorid` varchar(20) DEFAULT NULL,
  `unitid` varchar(20) DEFAULT NULL,
  `unitname` varchar(200) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `coord` text,
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_usergroupaccess
CREATE TABLE `tblref_usergroupaccess` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupid` varchar(30) DEFAULT NULL,
  `module` varchar(30) DEFAULT NULL,
  `moduletab` varchar(30) DEFAULT NULL,
  `functionid` varchar(50) DEFAULT NULL,
  `sequence` int(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13182 DEFAULT CHARSET=latin1;


-- Table: tblref_utilrate
CREATE TABLE `tblref_utilrate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mallid` varchar(20) DEFAULT NULL,
  `type` varchar(20) DEFAULT NULL,
  `EffDate` date DEFAULT NULL,
  `DateAdded` date DEFAULT NULL,
  `UtilRate` decimal(30,6) DEFAULT '0.000000',
  `AdminFee` decimal(30,6) DEFAULT '0.000000',
  `AdminFeeType` tinyint(3) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;


-- Table: tblref_wing
CREATE TABLE `tblref_wing` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `wingID` varchar(20) DEFAULT NULL,
  `wing` varchar(100) DEFAULT NULL,
  `mallID` varchar(20) DEFAULT NULL,
  `wingstat` int(5) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: tblref_workordermanual
CREATE TABLE `tblref_workordermanual` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(50) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `details` text,
  `workorderdate` varchar(50) DEFAULT NULL,
  `expensetype` varchar(100) DEFAULT NULL,
  `expenseamount` varchar(100) DEFAULT NULL,
  `remarksworkorder` text,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblref_workorderremarks
CREATE TABLE `tblref_workorderremarks` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `userid` varchar(30) DEFAULT NULL,
  `AssignedTask` varchar(50) DEFAULT NULL,
  `RemarksTask` text,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblrefbank
CREATE TABLE `tblrefbank` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `xcode` varchar(30) DEFAULT NULL,
  `description` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;


-- Table: tblrefpaymenttype
CREATE TABLE `tblrefpaymenttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `PaymentTypeCode` varchar(30) DEFAULT NULL,
  `PaymentTypeDesc` varchar(50) DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;


-- Table: tblreqcategory
CREATE TABLE `tblreqcategory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reqCatCode` varchar(20) DEFAULT NULL,
  `reqCatDesc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;


-- Table: tblreqtags
CREATE TABLE `tblreqtags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reqCatCode` varchar(20) DEFAULT NULL,
  `reqTagCode` varchar(20) DEFAULT NULL,
  `reqTagDesc` varchar(50) DEFAULT NULL,
  `reqTagAppr` int(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblsys_connsetup
CREATE TABLE `tblsys_connsetup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `HostAddress` varchar(50) DEFAULT '',
  `Username` varchar(20) DEFAULT '',
  `Password` varchar(20) DEFAULT '',
  `Port` varchar(10) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblsys_setup
CREATE TABLE `tblsys_setup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `corp_ID` varchar(30) NOT NULL,
  `corporatename` varchar(100) DEFAULT NULL,
  `about` text,
  `address` text,
  `contactnumber` varchar(15) DEFAULT NULL,
  `emailaddress` varchar(30) DEFAULT NULL,
  `maxnumofmall` varchar(10) DEFAULT NULL,
  `template` varchar(10) DEFAULT NULL,
  `corporatelogo` varchar(50) DEFAULT NULL,
  `mallprefix` char(3) DEFAULT NULL,
  `inqprefix` char(3) DEFAULT NULL,
  `appprefix` char(3) DEFAULT NULL,
  `TIN_number` varchar(20) DEFAULT NULL,
  `Telephone_number` varchar(20) DEFAULT NULL,
  `Fax_number` varchar(20) DEFAULT NULL,
  `website` varchar(30) DEFAULT NULL,
  `endodaynot` int(30) DEFAULT '0',
  `Machine_No` varchar(50) DEFAULT NULL,
  `Serial_No` varchar(50) DEFAULT NULL,
  `Accreditation_No` varchar(50) DEFAULT NULL,
  `softwaretype` int(10) DEFAULT '0',
  `filepath` varchar(100) DEFAULT NULL,
  `dbsetup` int(11) DEFAULT '0',
  `SFTPHost` varchar(100) DEFAULT NULL,
  `SFTPPort` varchar(20) DEFAULT NULL,
  `reqandpermit` int(5) DEFAULT '0',
  `adjustoccupancy` int(5) DEFAULT '0',
  `automerchantcode` int(5) DEFAULT '0',
  `floorandunitmeasurement` varchar(20) DEFAULT 'LengthWidth',
  `vatsetup` int(5) DEFAULT '1',
  `isClassification` int(5) DEFAULT '1',
  `isDepartment` int(5) DEFAULT '1',
  `isCategory` int(5) DEFAULT '1',
  `isAssocDues` int(5) DEFAULT '0',
  `isMultiCompSig` int(5) DEFAULT '0',
  `LP_Mall` varchar(100) DEFAULT NULL,
  `LP_TPS` varchar(100) DEFAULT NULL,
  `LP_FontColor` varchar(20) DEFAULT NULL,
  `LP_BGImage` varchar(40) DEFAULT NULL,
  `isOccupancy` int(5) DEFAULT NULL,
  `isJDAMapping` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`corp_ID`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tblsys_setup2
CREATE TABLE `tblsys_setup2` (
  `id` int(1) DEFAULT NULL,
  `corporatename` varchar(100) DEFAULT NULL,
  `about` text,
  `address` text,
  `contactnumber` varchar(15) DEFAULT NULL,
  `emailaddress` varchar(30) DEFAULT NULL,
  `maxnumofmall` varchar(10) DEFAULT NULL,
  `template` varchar(10) DEFAULT NULL,
  `corporatelogo` varchar(50) DEFAULT NULL,
  `mallprefix` char(3) DEFAULT NULL,
  `inqprefix` char(3) DEFAULT NULL,
  `appprefix` char(3) DEFAULT NULL,
  `TIN_number` varchar(20) DEFAULT NULL,
  `Telephone_number` varchar(20) DEFAULT NULL,
  `Fax_number` varchar(20) DEFAULT NULL,
  `website` varchar(30) DEFAULT NULL,
  `endodaynot` int(30) DEFAULT '0',
  `Machine_No` varchar(50) DEFAULT NULL,
  `Serial_No` varchar(50) DEFAULT NULL,
  `Accreditation_No` varchar(50) DEFAULT NULL,
  `softwaretype` int(10) DEFAULT '0',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltenant_chat
CREATE TABLE `tbltenant_chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messageid` varchar(20) DEFAULT NULL,
  `message` text,
  `sender_id` varchar(20) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltenant_chat_header
CREATE TABLE `tbltenant_chat_header` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_userid` varchar(20) DEFAULT NULL,
  `receiver_userid` varchar(20) DEFAULT NULL,
  `messageid` varchar(20) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblterms
CREATE TABLE `tblterms` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Term_No` varchar(30) NOT NULL,
  `Term_Name` mediumtext,
  `Group_ID` varchar(100) DEFAULT NULL,
  `Group_Name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Term_No`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tbltrans_amendment
CREATE TABLE `tbltrans_amendment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `AmendmentCode` varchar(20) DEFAULT NULL,
  `AmendmentReason` varchar(30) DEFAULT NULL,
  `AmendmentRemarks` varchar(255) DEFAULT NULL,
  `TerminationDate` date DEFAULT NULL,
  `EffectivityDate` date DEFAULT NULL,
  `AmendmentStatus` tinyint(5) DEFAULT '0',
  `isApplied` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_appid
CREATE TABLE `tbltrans_appid` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_bevlist
CREATE TABLE `tbltrans_bevlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UploadID` varchar(20) DEFAULT NULL,
  `Trans_Date` date DEFAULT NULL,
  `TenantID` varchar(40) DEFAULT NULL,
  `Trans_Code` varchar(30) DEFAULT NULL,
  `Trans_Desc` varchar(255) DEFAULT NULL,
  `Quantity` decimal(30,6) DEFAULT '0.000000',
  `Trans_Amount` decimal(30,6) DEFAULT '0.000000',
  `Trans_VAT` decimal(30,6) DEFAULT '0.000000',
  `Trans_TotAmount` decimal(30,6) DEFAULT '0.000000',
  `Reference` varchar(255) DEFAULT NULL,
  `Mall_ID` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;


-- Table: tbltrans_bevlogs
CREATE TABLE `tbltrans_bevlogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `UploadID` varchar(20) DEFAULT NULL,
  `UploadDate` date DEFAULT NULL,
  `UploadTime` time DEFAULT NULL,
  `UploadStatus` varchar(20) DEFAULT NULL,
  `UserID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tbltrans_chargeesca
CREATE TABLE `tbltrans_chargeesca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `YearStart` decimal(30,4) DEFAULT '0.0000',
  `YearBasis` decimal(30,4) DEFAULT '0.0000',
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=997 DEFAULT CHARSET=latin1;


-- Table: tbltrans_chargeesca_br
CREATE TABLE `tbltrans_chargeesca_br` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `EscaYear` varchar(30) DEFAULT NULL,
  `EscaStartDate` date DEFAULT NULL,
  `EscaEndDate` date DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `EscaAmount` decimal(30,4) DEFAULT '0.0000',
  `EscaTotal` decimal(30,4) DEFAULT '0.0000',
  `EscaStat` varchar(20) DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1899 DEFAULT CHARSET=latin1;


-- Table: tbltrans_chargeesca_br_history
CREATE TABLE `tbltrans_chargeesca_br_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `EscaYear` varchar(30) DEFAULT NULL,
  `EscaStartDate` date DEFAULT NULL,
  `EscaEndDate` date DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `EscaAmount` decimal(30,4) DEFAULT '0.0000',
  `EscaTotal` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_chargeesca_history
CREATE TABLE `tbltrans_chargeesca_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `YearStart` decimal(30,4) DEFAULT '0.0000',
  `YearBasis` decimal(30,4) DEFAULT '0.0000',
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_closingmeeting
CREATE TABLE `tbltrans_closingmeeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `closingmeetingID` varchar(20) DEFAULT NULL,
  `ProfileID` varchar(20) DEFAULT NULL,
  `LeadsName` varchar(20) DEFAULT NULL,
  `AssignedPerson` varchar(20) DEFAULT NULL,
  `Position` varchar(20) DEFAULT NULL,
  `Company_Name` varchar(20) DEFAULT NULL,
  `First_Name` varchar(20) DEFAULT NULL,
  `Middle_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(20) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Mobile_No` varchar(11) DEFAULT NULL,
  `Telephone_No` varchar(16) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `Website` varchar(20) DEFAULT NULL,
  `Remarks` varchar(20) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Full_name` varchar(20) DEFAULT NULL,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_company
CREATE TABLE `tbltrans_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` varchar(50) NOT NULL DEFAULT '',
  `Company` varchar(100) DEFAULT NULL,
  `industry` varchar(50) DEFAULT NULL,
  `businessAddress` text,
  `owner_firstname` varchar(50) DEFAULT NULL,
  `owner_middlename` varchar(50) DEFAULT NULL,
  `owner_lastname` varchar(50) DEFAULT NULL,
  `permanent_address` text,
  `current_address` text,
  `billing_address` text,
  `filename` varchar(50) DEFAULT NULL,
  `ext` varchar(10) DEFAULT NULL,
  `width` float DEFAULT NULL,
  `height` float DEFAULT NULL,
  `merchant_code` varchar(10) DEFAULT NULL,
  `automerchant_code` varchar(20) DEFAULT NULL,
  `BillerID` varbinary(20) DEFAULT NULL,
  `JDA_Comp_ID` varchar(30) DEFAULT NULL,
  `MallID` varchar(30) DEFAULT NULL,
  `TINNo` varbinary(30) DEFAULT NULL,
  PRIMARY KEY (`CompanyID`),
  UNIQUE KEY `id` (`id`),
  KEY `IDX_CompanyName` (`Company`(20)),
  KEY `IDX_Industry` (`industry`(15)),
  KEY `IDX_MerchantCode` (`merchant_code`(3))
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;


-- Table: tbltrans_company_contact_person
CREATE TABLE `tbltrans_company_contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ConID` varchar(30) DEFAULT NULL,
  `Confname` varchar(30) DEFAULT NULL,
  `Conmname` varchar(30) DEFAULT NULL,
  `Conlname` varchar(30) DEFAULT NULL,
  `custID` varchar(30) DEFAULT NULL,
  `name` varchar(80) DEFAULT NULL,
  `designation` varchar(30) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `isActive` int(11) DEFAULT '1',
  `isPrimary` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=183 DEFAULT CHARSET=latin1;


-- Table: tbltrans_company_contact_person_contacts
CREATE TABLE `tbltrans_company_contact_person_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ConID` varchar(30) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `content` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=603 DEFAULT CHARSET=latin1;


-- Table: tbltrans_company_contacts
CREATE TABLE `tbltrans_company_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` varchar(50) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `content` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1194 DEFAULT CHARSET=latin1;


-- Table: tbltrans_company_owner_contacts
CREATE TABLE `tbltrans_company_owner_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` varchar(50) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `content` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_companysig
CREATE TABLE `tbltrans_companysig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `CompanyID` varchar(20) DEFAULT NULL,
  `firstname` varchar(40) DEFAULT NULL,
  `middlename` varchar(40) DEFAULT NULL,
  `lastname` varchar(40) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_contractsigning
CREATE TABLE `tbltrans_contractsigning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contractsigningID` varchar(20) DEFAULT NULL,
  `ProfileID` varchar(20) DEFAULT NULL,
  `LeadsName` varchar(20) DEFAULT NULL,
  `AssignedPerson` varchar(20) DEFAULT NULL,
  `Position` varchar(20) DEFAULT NULL,
  `Company_Name` varchar(20) DEFAULT NULL,
  `First_Name` varchar(20) DEFAULT NULL,
  `Middle_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(20) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Mobile_No` varchar(11) DEFAULT NULL,
  `Telephone_No` varchar(20) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `Website` varchar(20) DEFAULT NULL,
  `Remarks` varchar(20) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Full_name` varchar(20) DEFAULT NULL,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_demo
CREATE TABLE `tbltrans_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `demoID` varchar(20) DEFAULT NULL,
  `ProfileID` varchar(20) DEFAULT NULL,
  `LeadsName` varchar(20) DEFAULT NULL,
  `AssignedPerson` varchar(20) DEFAULT NULL,
  `Position` varchar(20) DEFAULT NULL,
  `Company_Name` varchar(20) DEFAULT NULL,
  `First_Name` varchar(20) DEFAULT NULL,
  `Middle_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(20) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Mobile_No` varchar(11) DEFAULT NULL,
  `Telephone_No` varchar(16) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `Website` varchar(20) DEFAULT NULL,
  `Remarks` varchar(20) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Full_name` varchar(20) DEFAULT NULL,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_eod
CREATE TABLE `tbltrans_eod` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `eoddate` date DEFAULT NULL,
  `processby` varchar(30) DEFAULT NULL,
  `computerdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=latin1;


-- Table: tbltrans_escalation
CREATE TABLE `tbltrans_escalation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `EscaYear` varchar(20) DEFAULT NULL,
  `EscaStartDate` date DEFAULT NULL,
  `EscaEndDate` date DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `AccuEscaRate` decimal(30,4) DEFAULT '0.0000',
  `EscaAmount` decimal(30,4) DEFAULT '0.0000',
  `EscaTotal` decimal(30,4) DEFAULT '0.0000',
  `EscaStat` varchar(20) DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1886 DEFAULT CHARSET=latin1;


-- Table: tbltrans_escalation_copy
CREATE TABLE `tbltrans_escalation_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `EscaYear` varchar(20) DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `AccuEscaRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_escalation_history
CREATE TABLE `tbltrans_escalation_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `EscaYear` varchar(20) DEFAULT NULL,
  `EscaStartDate` date DEFAULT NULL,
  `EscaEndDate` date DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `AccueEscaRate` decimal(30,4) DEFAULT '0.0000',
  `EscaAmount` decimal(30,4) DEFAULT '0.0000',
  `EscaTotal` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_events
CREATE TABLE `tbltrans_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `EVCode` varchar(30) DEFAULT NULL,
  `EVDesc` varchar(30) DEFAULT NULL,
  `LssrMjr` varchar(30) DEFAULT NULL,
  `LssrMnr` varchar(30) DEFAULT NULL,
  `LssrCOAStore` varchar(30) DEFAULT NULL,
  `VndrMjr` varchar(30) DEFAULT NULL,
  `VndrMnr` varchar(30) DEFAULT NULL,
  `VndrCOAStore` varchar(30) DEFAULT NULL,
  `WthTaxRate` decimal(30,4) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tbltrans_hierarchy
CREATE TABLE `tbltrans_hierarchy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hiecode` varchar(20) DEFAULT '',
  `hiedesc` varchar(150) DEFAULT '',
  `module` varchar(50) DEFAULT '',
  `role` varchar(20) DEFAULT '',
  `ulevel` varchar(20) DEFAULT '',
  `appdfault` int(1) DEFAULT NULL,
  `property` varchar(20) DEFAULT '',
  `xadded` varchar(20) DEFAULT '',
  `xadddt` datetime DEFAULT NULL,
  `xeditted` varchar(20) DEFAULT '',
  `xedtdt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;


-- Table: tbltrans_hierarchy_reqgroup
CREATE TABLE `tbltrans_hierarchy_reqgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `reqid` varchar(20) DEFAULT '',
  `reqdesc` varchar(100) DEFAULT '',
  `xaddedby` varchar(20) DEFAULT '',
  `xadddt` datetime DEFAULT NULL,
  `xeditby` varchar(20) DEFAULT '',
  `xeditdt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;


-- Table: tbltrans_inquiry
CREATE TABLE `tbltrans_inquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Inquiry_ID` varchar(50) DEFAULT '',
  `Application_ID` varchar(50) DEFAULT '',
  `Mall` varchar(50) DEFAULT '',
  `Mall_ID` varchar(50) DEFAULT NULL,
  `UnitID` varchar(50) DEFAULT '',
  `UnitType` varchar(10) DEFAULT '',
  `TradeID` varchar(50) DEFAULT '',
  `Trade_Name` varchar(100) DEFAULT '',
  `Company_ID` varchar(50) DEFAULT '',
  `Company_Name` varchar(100) DEFAULT '',
  `Industry` varchar(50) DEFAULT '',
  `ClassID` varchar(50) DEFAULT '',
  `DepartmentID` varchar(50) DEFAULT '',
  `CategoryID` varchar(50) DEFAULT '',
  `Address` text,
  `User_ID` varchar(50) DEFAULT '',
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `applicationDate` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT 'Pending',
  `depamount` decimal(40,6) DEFAULT '0.000000',
  `date_inquired` date DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `date_applied` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_confirmed` datetime DEFAULT NULL,
  `time_inquired` time DEFAULT NULL,
  `req_status` varchar(10) DEFAULT 'Incomplete',
  `TenantID` varchar(30) DEFAULT '',
  `billingtype` varchar(30) DEFAULT '',
  `billingperc` varchar(30) DEFAULT '',
  `desired_noofdays` float DEFAULT '0',
  `desired_noofmonths` float DEFAULT '0',
  `inq_by` varchar(80) DEFAULT '',
  `app_by` varchar(80) DEFAULT '',
  `mod_by` varchar(80) DEFAULT '',
  `appr_by` varchar(80) DEFAULT '',
  `merchant_code` varchar(20) DEFAULT '',
  `owner_card_number` varchar(50) DEFAULT '',
  `userid_aw` varchar(20) DEFAULT NULL,
  `desired_noofyears` int(11) DEFAULT '0',
  `month_adv` text,
  `payment_terms` varchar(20) DEFAULT '',
  `payment_type` varchar(20) DEFAULT '',
  `contractID` varchar(30) DEFAULT '',
  `reservationfee` text,
  `cardtype` varchar(20) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `authno` varchar(30) DEFAULT NULL,
  `seccode` varchar(30) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `bankfrom` varchar(20) DEFAULT NULL,
  `bf_accno` varchar(30) DEFAULT NULL,
  `bankto` varchar(20) DEFAULT NULL,
  `bt_accno` varchar(30) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `monthly_dues` decimal(40,6) DEFAULT '0.000000',
  `daily_dues` decimal(40,6) DEFAULT '0.000000',
  `assoc_dues` decimal(40,6) DEFAULT '0.000000',
  `Contract_NumSAP` varchar(50) DEFAULT NULL,
  `Company_CodeSAP` varchar(50) DEFAULT NULL,
  `leadsID` varchar(20) DEFAULT NULL,
  `forFinal` tinyint(3) DEFAULT '0',
  `S2Leasing` tinyint(3) DEFAULT '0',
  `mallCompanyID` varchar(20) NOT NULL,
  `inqSource` varchar(20) NOT NULL,
  `inqPrcssOwnr` varchar(30) DEFAULT NULL,
  `BillerID` varchar(30) NOT NULL,
  `1st_app_aw` varchar(20) DEFAULT '',
  `1st_date_aw` datetime DEFAULT NULL,
  `1st_marks_aw` varchar(200) DEFAULT '',
  `2nd_app_aw` varchar(20) DEFAULT '',
  `2nd_date_aw` datetime DEFAULT NULL,
  `2nd_marks_aw` varchar(200) DEFAULT '',
  `1st_app_cont` varchar(20) DEFAULT '',
  `1st_date_cont` datetime DEFAULT NULL,
  `1st_marks_cont` varchar(200) DEFAULT '',
  `2nd_app_cont` varchar(20) DEFAULT '',
  `2nd_date_cont` datetime DEFAULT NULL,
  `2nd_marks_cont` varchar(200) DEFAULT '',
  `awardstatus` varchar(20) DEFAULT '',
  `alluserid` varchar(20) DEFAULT '',
  `eventTag` tinyint(3) DEFAULT '0',
  `ActiveProposal` tinyint(5) DEFAULT '1',
  `isDirect` tinyint(5) DEFAULT '0',
  `isAmendment` tinyint(5) DEFAULT '0',
  `AmendmentCode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_appid` (`Application_ID`(12)),
  KEY `IDX_contractid` (`contractID`),
  KEY `IDX_dateto` (`dateto`),
  KEY `IDX_unitid` (`UnitID`(10)),
  KEY `fk_cat` (`CategoryID`),
  KEY `fk_class` (`ClassID`),
  KEY `fk_comp` (`Company_ID`),
  KEY `fk_dept` (`DepartmentID`),
  KEY `fk_mallID` (`Mall_ID`),
  KEY `fk_userID` (`User_ID`),
  KEY `idx_biller` (`BillerID`),
  KEY `idx_constraint` (`Industry`),
  KEY `idx_soure` (`inqSource`),
  KEY `inqPrcssOwnr` (`inqPrcssOwnr`),
  KEY `mallCompanyID` (`mallCompanyID`),
  CONSTRAINT `fk_mallID` FOREIGN KEY (`Mall_ID`) REFERENCES `tblref_mall` (`mallid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_processowner` FOREIGN KEY (`inqPrcssOwnr`) REFERENCES `tblref_process_owner` (`deptCode`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_source` FOREIGN KEY (`inqSource`) REFERENCES `tblref_source` (`source_code`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `fk_userID` FOREIGN KEY (`User_ID`) REFERENCES `tbluser` (`userid`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_inquiry_ibfk_1` FOREIGN KEY (`mallCompanyID`) REFERENCES `tblref_mallcompany` (`MallCompanyID`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=231 DEFAULT CHARSET=latin1;


-- Table: tbltrans_inquiry_copy
CREATE TABLE `tbltrans_inquiry_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Inquiry_ID` varchar(50) NOT NULL DEFAULT '',
  `Application_ID` varchar(50) NOT NULL DEFAULT '',
  `Mall` varchar(50) DEFAULT '',
  `Mall_ID` varchar(50) DEFAULT '',
  `UnitID` varchar(50) DEFAULT '',
  `UnitType` varchar(10) DEFAULT '',
  `TradeID` varchar(50) DEFAULT '',
  `Trade_Name` varchar(100) DEFAULT '',
  `Company_ID` varchar(50) DEFAULT '',
  `Company_Name` varchar(100) DEFAULT '',
  `Industry` varchar(50) NOT NULL,
  `ClassID` varchar(50) DEFAULT '',
  `DepartmentID` varchar(50) DEFAULT '',
  `CategoryID` varchar(50) DEFAULT '',
  `Address` text,
  `User_ID` varchar(50) DEFAULT '',
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `applicationDate` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT 'Pending',
  `depamount` decimal(40,6) DEFAULT '0.000000',
  `date_inquired` date DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `date_applied` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_confirmed` datetime DEFAULT NULL,
  `time_inquired` time DEFAULT NULL,
  `req_status` varchar(10) DEFAULT 'Incomplete',
  `TenantID` varchar(30) DEFAULT '',
  `billingtype` varchar(30) DEFAULT '',
  `billingperc` varchar(30) DEFAULT '',
  `desired_noofdays` int(11) DEFAULT '0',
  `desired_noofmonths` int(11) DEFAULT '0',
  `desired_noofyears` int(11) DEFAULT '0',
  `inq_by` varchar(30) DEFAULT '',
  `app_by` varchar(30) DEFAULT '',
  `mod_by` varchar(30) DEFAULT '',
  `appr_by` varchar(30) DEFAULT '',
  `merchant_code` char(3) DEFAULT '',
  `owner_card_number` varchar(50) DEFAULT '',
  `month_adv` text,
  `payment_terms` varchar(20) DEFAULT '',
  `payment_type` varchar(20) DEFAULT '',
  `contractID` varchar(30) DEFAULT '',
  `reservationfee` text,
  `cardtype` varchar(20) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `authno` varchar(30) DEFAULT NULL,
  `seccode` varchar(30) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `bankfrom` varchar(20) DEFAULT NULL,
  `bf_accno` varchar(30) DEFAULT NULL,
  `bankto` varchar(20) DEFAULT NULL,
  `bt_accno` varchar(30) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `monthly_dues` decimal(40,6) DEFAULT '0.000000',
  `daily_dues` decimal(40,6) DEFAULT '0.000000',
  `assoc_dues` decimal(40,6) DEFAULT '0.000000',
  `Contract_NumSAP` varchar(50) DEFAULT NULL,
  `Company_CodeSAP` varchar(50) DEFAULT NULL,
  `leadsID` varchar(20) DEFAULT NULL,
  `forFinal` tinyint(3) DEFAULT '0',
  `S2Leasing` tinyint(3) DEFAULT '0',
  `mallCompanyID` varchar(20) NOT NULL,
  `inqSource` varchar(30) DEFAULT NULL,
  `inqPrcssOwnr` varchar(30) DEFAULT NULL,
  `BillerID` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`,`Inquiry_ID`,`Application_ID`,`Industry`),
  KEY `IDX_appid` (`Application_ID`(12)),
  KEY `IDX_inqid` (`Inquiry_ID`(12)),
  KEY `IDX_contractid` (`contractID`),
  KEY `IDX_dateconfirmed` (`date_confirmed`),
  KEY `IDX_datefrom` (`datefrom`),
  KEY `IDX_dateinq` (`date_inquired`),
  KEY `IDX_dateto` (`dateto`),
  KEY `IDX_mallid` (`Mall_ID`(10)),
  KEY `IDX_status` (`Status`(10)),
  KEY `IDX_unitid` (`UnitID`(10))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_inquiry_copy1
CREATE TABLE `tbltrans_inquiry_copy1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Inquiry_ID` varchar(50) NOT NULL DEFAULT '',
  `Application_ID` varchar(50) NOT NULL DEFAULT '',
  `Mall` varchar(50) DEFAULT '',
  `Mall_ID` varchar(50) DEFAULT NULL,
  `UnitID` varchar(50) DEFAULT '',
  `UnitType` varchar(10) DEFAULT '',
  `TradeID` varchar(50) DEFAULT '',
  `Trade_Name` varchar(100) DEFAULT '',
  `Company_ID` varchar(50) DEFAULT '',
  `Company_Name` varchar(100) DEFAULT '',
  `Industry` varchar(50) DEFAULT '',
  `ClassID` varchar(50) DEFAULT '',
  `DepartmentID` varchar(50) DEFAULT '',
  `CategoryID` varchar(50) DEFAULT '',
  `Address` text,
  `User_ID` varchar(50) DEFAULT '',
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `applicationDate` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT 'Pending',
  `depamount` decimal(40,6) DEFAULT '0.000000',
  `date_inquired` date DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `date_applied` datetime DEFAULT NULL,
  `date_modified` datetime DEFAULT NULL,
  `date_confirmed` datetime DEFAULT NULL,
  `time_inquired` time DEFAULT NULL,
  `req_status` varchar(10) DEFAULT 'Incomplete',
  `TenantID` varchar(30) DEFAULT '',
  `billingtype` varchar(30) DEFAULT '',
  `billingperc` varchar(30) DEFAULT '',
  `desired_noofdays` float DEFAULT '0',
  `desired_noofmonths` float DEFAULT '0',
  `inq_by` varchar(80) DEFAULT '',
  `app_by` varchar(80) DEFAULT '',
  `mod_by` varchar(80) DEFAULT '',
  `appr_by` varchar(80) DEFAULT '',
  `merchant_code` varchar(20) DEFAULT '',
  `owner_card_number` varchar(50) DEFAULT '',
  `desired_noofyears` int(11) DEFAULT '0',
  `month_adv` text,
  `payment_terms` varchar(20) DEFAULT '',
  `payment_type` varchar(20) DEFAULT '',
  `contractID` varchar(30) DEFAULT '',
  `reservationfee` text,
  `cardtype` varchar(20) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `authno` varchar(30) DEFAULT NULL,
  `seccode` varchar(30) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `bankfrom` varchar(20) DEFAULT NULL,
  `bf_accno` varchar(30) DEFAULT NULL,
  `bankto` varchar(20) DEFAULT NULL,
  `bt_accno` varchar(30) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `monthly_dues` decimal(40,6) DEFAULT '0.000000',
  `daily_dues` decimal(40,6) DEFAULT '0.000000',
  `assoc_dues` decimal(40,6) DEFAULT '0.000000',
  `Contract_NumSAP` varchar(50) DEFAULT NULL,
  `Company_CodeSAP` varchar(50) DEFAULT NULL,
  `leadsID` varchar(20) DEFAULT NULL,
  `forFinal` tinyint(3) DEFAULT '0',
  `S2Leasing` tinyint(3) DEFAULT '0',
  `mallCompanyID` varchar(20) NOT NULL,
  `inqSource` varchar(20) NOT NULL,
  `inqPrcssOwnr` varchar(30) DEFAULT NULL,
  `BillerID` varchar(30) NOT NULL,
  `1st_app_aw` varchar(20) DEFAULT '',
  `1st_date_aw` datetime DEFAULT NULL,
  `1st_marks_aw` varchar(200) DEFAULT '',
  `2nd_app_aw` varchar(20) DEFAULT '',
  `2nd_date_aw` datetime DEFAULT NULL,
  `2nd_marks_aw` varchar(200) DEFAULT '',
  `1st_app_cont` varchar(20) DEFAULT '',
  `1st_date_cont` datetime DEFAULT NULL,
  `1st_marks_cont` varchar(200) DEFAULT '',
  `2nd_app_cont` varchar(20) DEFAULT '',
  `2nd_date_cont` datetime DEFAULT NULL,
  `2nd_marks_cont` varchar(200) DEFAULT '',
  `awardstatus` varchar(20) DEFAULT '',
  `alluserid` varchar(20) DEFAULT '',
  `eventTag` tinyint(3) DEFAULT '0',
  `ActiveProposal` tinyint(5) DEFAULT '1',
  PRIMARY KEY (`Inquiry_ID`),
  UNIQUE KEY `id` (`id`),
  KEY `IDX_appid` (`Application_ID`(12)),
  KEY `IDX_contractid` (`contractID`),
  KEY `IDX_dateto` (`dateto`),
  KEY `IDX_unitid` (`UnitID`(10)),
  KEY `fk_cat` (`CategoryID`),
  KEY `fk_class` (`ClassID`),
  KEY `fk_comp` (`Company_ID`),
  KEY `fk_dept` (`DepartmentID`),
  KEY `fk_mallID` (`Mall_ID`),
  KEY `fk_userID` (`User_ID`),
  KEY `idx_biller` (`BillerID`),
  KEY `idx_constraint` (`Industry`),
  KEY `idx_soure` (`inqSource`),
  KEY `inqPrcssOwnr` (`inqPrcssOwnr`)
) ENGINE=InnoDB AUTO_INCREMENT=87 DEFAULT CHARSET=latin1;


-- Table: tbltrans_inquiry_history
CREATE TABLE `tbltrans_inquiry_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ApplicationID` varchar(20) DEFAULT NULL,
  `Mall` varchar(50) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `TradeID` varchar(20) DEFAULT NULL,
  `TradeName` varchar(100) DEFAULT NULL,
  `CompanyID` varchar(20) DEFAULT NULL,
  `CompanyName` varchar(100) DEFAULT NULL,
  `Industry` varchar(20) DEFAULT NULL,
  `ClassID` varchar(20) DEFAULT NULL,
  `DepartmentID` varchar(20) DEFAULT NULL,
  `CategoryID` varchar(20) DEFAULT NULL,
  `User_ID` varchar(20) DEFAULT NULL,
  `DateFrom` date DEFAULT NULL,
  `DateTo` date DEFAULT NULL,
  `ApplicationDate` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT 'Pending',
  `Date_Inquired` date DEFAULT NULL,
  `Date_Approved` date DEFAULT NULL,
  `Date_Applied` date DEFAULT NULL,
  `Date_Modified` date DEFAULT NULL,
  `Date_Confirmed` date DEFAULT NULL,
  `Time_Inquired` date DEFAULT NULL,
  `Req_Status` varchar(10) DEFAULT 'Incomplete',
  `TenantID` varchar(20) DEFAULT NULL,
  `BillingType` varchar(30) DEFAULT NULL,
  `BillingPercent` varchar(5) DEFAULT NULL,
  `PaymentTerms` varchar(20) DEFAULT NULL,
  `NoofDays` varchar(20) DEFAULT NULL,
  `NoofMonths` varchar(20) DEFAULT NULL,
  `NoofYears` varchar(20) DEFAULT NULL,
  `InquiryBy` varchar(80) DEFAULT NULL,
  `ApplicationBy` varchar(80) DEFAULT NULL,
  `Merchant_Code` varchar(20) DEFAULT NULL,
  `UserID_AW` varchar(20) DEFAULT NULL,
  `ContractID` varchar(20) DEFAULT NULL,
  `forFinal` tinyint(3) DEFAULT '0',
  `S2Leasing` tinyint(3) DEFAULT '0',
  `MallCompanyID` varchar(20) DEFAULT NULL,
  `inqSource` varchar(20) DEFAULT NULL,
  `inqPrcssOwnr` varchar(20) DEFAULT NULL,
  `BillerID` varchar(30) DEFAULT NULL,
  `Monthly_Dues` decimal(40,6) DEFAULT '0.000000',
  `Daily_Dues` decimal(40,6) DEFAULT '0.000000',
  `Assoc_Dues` decimal(40,6) DEFAULT '0.000000',
  `1st_app_aw` varchar(20) DEFAULT NULL,
  `1st_date_aw` datetime DEFAULT NULL,
  `1st_marks_aw` varchar(200) DEFAULT NULL,
  `2nd_app_aw` varchar(20) DEFAULT NULL,
  `2nd_date_aw` datetime DEFAULT NULL,
  `2nd_marks_aw` varchar(200) DEFAULT NULL,
  `1st_app_cont` varchar(20) DEFAULT NULL,
  `1st_date_cont` datetime DEFAULT NULL,
  `1st_marks_cont` varchar(200) DEFAULT NULL,
  `2nd_app_cont` varchar(20) DEFAULT NULL,
  `2nd_date_cont` datetime DEFAULT NULL,
  `2nd_marks_cont` varchar(200) DEFAULT NULL,
  `awardstatus` varchar(20) DEFAULT NULL,
  `alluserid` varchar(20) DEFAULT NULL,
  `eventTag` tinyint(3) DEFAULT '0',
  `ActiveProposal` tinyint(5) DEFAULT '0',
  `isDirect` tinyint(5) DEFAULT '0',
  `isAmendment` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_inquiry_unit
CREATE TABLE `tbltrans_inquiry_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbltrans_inquiry_unit_ibfk_1` (`UnitID`),
  CONSTRAINT `tbltrans_inquiry_unit_ibfk_1` FOREIGN KEY (`UnitID`) REFERENCES `tblref_unit` (`unitid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=556 DEFAULT CHARSET=latin1;


-- Table: tbltrans_inquiry_unit_history
CREATE TABLE `tbltrans_inquiry_unit_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_items
CREATE TABLE `tbltrans_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TransactionID` varchar(30) DEFAULT NULL,
  `CardID` varchar(30) NOT NULL,
  `Name` varchar(100) DEFAULT NULL,
  `Description` text,
  `Notes` text,
  `Quantity` int(11) DEFAULT NULL,
  `DepositDate` date DEFAULT NULL,
  `DepositTime` time DEFAULT NULL,
  `ClaimDate` date DEFAULT NULL,
  `ClaimTime` time DEFAULT NULL,
  `Status` varchar(30) DEFAULT 'Deposited',
  `userid` varchar(30) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`,`CardID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_lca_plot
CREATE TABLE `tbltrans_lca_plot` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Inquiry_ID` varchar(20) DEFAULT NULL,
  `floorid` varchar(20) DEFAULT NULL,
  `tradeid` varchar(20) DEFAULT NULL,
  `tradename` varchar(200) DEFAULT NULL,
  `unitid` varchar(20) DEFAULT NULL,
  `padding` varchar(500) DEFAULT NULL,
  `totalarea` float DEFAULT '0',
  `dateadded` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads
CREATE TABLE `tbltrans_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `TradeID` varchar(20) DEFAULT NULL,
  `CompanyID` varchar(20) DEFAULT NULL,
  `LeadsName` varchar(50) DEFAULT NULL,
  `AssignedPerson` varchar(20) DEFAULT NULL,
  `Position` varchar(30) DEFAULT NULL,
  `Company_Name` varchar(50) DEFAULT NULL,
  `First_Name` varchar(30) DEFAULT NULL,
  `Middle_Name` varchar(30) DEFAULT NULL,
  `Last_Name` varchar(30) DEFAULT NULL,
  `Remarks` text,
  `Source` varchar(20) DEFAULT NULL,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `Status` varchar(20) DEFAULT 'Lead',
  `Full_Name` text,
  `xDate` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_leadsid` (`leadsID`(10)),
  KEY `IDX_tradeid` (`TradeID`(10)),
  KEY `IDX_companyid` (`CompanyID`(10)),
  KEY `IDX_status` (`Status`(5))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_activities
CREATE TABLE `tbltrans_leads_activities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ActivityID` varchar(20) DEFAULT NULL,
  `leadsID` varchar(20) DEFAULT NULL,
  `Subject` varchar(50) DEFAULT NULL,
  `Remarks` text,
  `SetDate` date DEFAULT NULL,
  `SetTime` time DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_attachments
CREATE TABLE `tbltrans_leads_attachments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `filename` text,
  `filetype` varchar(20) DEFAULT NULL,
  `ActivityID` varchar(20) DEFAULT '',
  `SubLeadsID` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_awareness
CREATE TABLE `tbltrans_leads_awareness` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `AwarenessID` varchar(20) DEFAULT NULL,
  `Subject` varchar(50) DEFAULT NULL,
  `Details` text,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_closingmeeting
CREATE TABLE `tbltrans_leads_closingmeeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `ClosingMeetingID` varchar(20) DEFAULT NULL,
  `Subject` varchar(50) DEFAULT NULL,
  `Details` text,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_contractsigning
CREATE TABLE `tbltrans_leads_contractsigning` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `ContractSigningID` varchar(20) DEFAULT NULL,
  `Subject` varchar(50) DEFAULT NULL,
  `Details` text,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_demo
CREATE TABLE `tbltrans_leads_demo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `DemoID` varchar(20) DEFAULT NULL,
  `Subject` varchar(50) DEFAULT NULL,
  `Details` text,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leads_referral
CREATE TABLE `tbltrans_leads_referral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(20) DEFAULT NULL,
  `ReferralID` varchar(20) DEFAULT NULL,
  `Subject` varchar(50) DEFAULT NULL,
  `Details` text,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `xDate` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leasingapplication
CREATE TABLE `tbltrans_leasingapplication` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `applicationID` varchar(100) DEFAULT NULL,
  `inquiryID` varchar(100) DEFAULT NULL,
  `tradename` varchar(100) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `industryID` varchar(100) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `company_telno` varchar(100) DEFAULT NULL,
  `company_faxno` varchar(100) DEFAULT NULL,
  `company_email` varchar(100) DEFAULT NULL,
  `company_website` varchar(100) DEFAULT NULL,
  `company_franchisor` varchar(100) DEFAULT NULL,
  `company_owner_firstname` varchar(100) DEFAULT NULL,
  `company_owner_midname` varchar(100) DEFAULT NULL,
  `company_owner_lastname` varchar(100) DEFAULT NULL,
  `company_owner_civilstat` varchar(100) DEFAULT NULL,
  `company_owner_home_address` varchar(100) DEFAULT NULL,
  `company_owner_permanent_address` varchar(100) DEFAULT NULL,
  `company_owner_billing_address` varchar(100) DEFAULT NULL,
  `company_contact_firstname` varchar(100) DEFAULT NULL,
  `company_contact_midname` varchar(100) DEFAULT NULL,
  `company_contact_lastname` varchar(100) DEFAULT NULL,
  `company_contact_designation` varchar(100) DEFAULT NULL,
  `company_contact_mobno` varchar(100) DEFAULT NULL,
  `company_contact_telno` varchar(100) DEFAULT NULL,
  `merchandise_dep_name` varchar(100) DEFAULT NULL,
  `merchandise_dep_id` varchar(100) DEFAULT NULL,
  `merchandise_class_name` varchar(100) DEFAULT NULL,
  `merchandise_class_id` varchar(100) DEFAULT NULL,
  `merchandise_cat_name` varchar(100) DEFAULT NULL,
  `merchandise_cat_id` varchar(100) DEFAULT NULL,
  `Status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leasingapplication_affiliated
CREATE TABLE `tbltrans_leasingapplication_affiliated` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `inquiryID` varchar(200) DEFAULT NULL,
  `applicationID` varchar(200) DEFAULT NULL,
  `company_name` varchar(200) DEFAULT NULL,
  `line_of_business` varchar(200) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `tel_no` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leasingapplication_contactperson
CREATE TABLE `tbltrans_leasingapplication_contactperson` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ConID` varchar(100) DEFAULT NULL,
  `Confname` varchar(100) DEFAULT NULL,
  `Conmname` varchar(100) DEFAULT NULL,
  `Conlname` varchar(100) DEFAULT NULL,
  `custID` varchar(100) DEFAULT NULL,
  `inqID` varchar(100) DEFAULT NULL,
  `appID` varchar(100) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `designation` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `email_address` varchar(100) DEFAULT NULL,
  `mobnum` varchar(100) DEFAULT NULL,
  `telnum` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `filetype` varchar(100) DEFAULT NULL,
  `filesize` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leasingapplication_dp
CREATE TABLE `tbltrans_leasingapplication_dp` (
  `appID` varchar(100) DEFAULT NULL,
  `reqID` varchar(100) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `filetype` varchar(100) DEFAULT NULL,
  `filesize` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leasingapplication_owner_telno
CREATE TABLE `tbltrans_leasingapplication_owner_telno` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `inquiryID` varchar(200) DEFAULT NULL,
  `applicationID` varchar(200) DEFAULT NULL,
  `tel_no` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_leasingapplicationreq
CREATE TABLE `tbltrans_leasingapplicationreq` (
  `appID` varchar(20) DEFAULT NULL,
  `reqID` varchar(20) DEFAULT NULL,
  `type_req_ID` varchar(20) DEFAULT NULL,
  `filename` text,
  `filetype` varchar(100) DEFAULT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `docname` text,
  `docdesc` text,
  `proposalNum` tinyint(3) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_mallconf
CREATE TABLE `tbltrans_mallconf` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TransID` varchar(20) DEFAULT NULL,
  `userid` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `TransDate` date DEFAULT NULL,
  `TransTime` time DEFAULT NULL,
  `FileType` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


-- Table: tbltrans_memo
CREATE TABLE `tbltrans_memo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MemoID` varchar(20) DEFAULT NULL,
  `MemoDate` date DEFAULT NULL,
  `MemoTime` time DEFAULT NULL,
  `TenantID` varchar(20) DEFAULT NULL,
  `MemoSubj` text,
  `MemoContent` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_memo_attachment
CREATE TABLE `tbltrans_memo_attachment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `MemoID` varchar(20) DEFAULT NULL,
  `MemoAttachment` text,
  `filetype` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- Table: tbltrans_paymentapplogs
CREATE TABLE `tbltrans_paymentapplogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TransID` varchar(20) DEFAULT NULL,
  `TenantID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `xcode` varchar(80) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `qty` decimal(40,2) DEFAULT '0.00',
  `xdate` date DEFAULT NULL,
  `PaymentAmount` decimal(40,2) DEFAULT '0.00',
  `PaymentOR` varchar(30) DEFAULT NULL,
  `Amount` decimal(40,2) DEFAULT '0.00',
  `VATAmount` decimal(40,2) DEFAULT '0.00',
  `TotalAmount` decimal(40,2) DEFAULT '0.00',
  `Balance` decimal(40,2) DEFAULT '0.00',
  `Reference` varchar(100) DEFAULT NULL,
  `UserID` varchar(30) DEFAULT NULL,
  `PaymentTypeID` varchar(50) DEFAULT NULL,
  `PaymentTypeDesc` varchar(50) DEFAULT NULL,
  `PostingDate` date DEFAULT NULL,
  `PostingTime` time DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_paymentapplogs_copy
CREATE TABLE `tbltrans_paymentapplogs_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `xcode` varchar(80) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `qty` decimal(30,6) DEFAULT '0.000000',
  `xdate` date DEFAULT NULL,
  `PaymentAmount` decimal(30,6) DEFAULT '0.000000',
  `PaymentOR` varchar(30) DEFAULT NULL,
  `Amount` decimal(30,6) DEFAULT '0.000000',
  `VATAmount` decimal(30,6) DEFAULT '0.000000',
  `TotalAmount` decimal(30,6) DEFAULT '0.000000',
  `Balance` decimal(30,6) DEFAULT '0.000000',
  `Reference` varchar(100) DEFAULT NULL,
  `UserID` varchar(30) DEFAULT NULL,
  `PaymentTypeID` varchar(50) DEFAULT NULL,
  `PaymentTypeDesc` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;


-- Table: tbltrans_pdc
CREATE TABLE `tbltrans_pdc` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `inquiryid` varchar(60) NOT NULL DEFAULT '',
  `customerid` varchar(60) NOT NULL DEFAULT '',
  `unitid` varchar(20) DEFAULT NULL,
  `lname` varchar(60) NOT NULL DEFAULT '',
  `fname` varchar(60) NOT NULL DEFAULT '',
  `pdcdate` date DEFAULT NULL,
  `amount` decimal(15,6) DEFAULT '0.000000',
  `depositorystat` varchar(50) NOT NULL DEFAULT 'For Deposit',
  `checkstat` varchar(50) NOT NULL DEFAULT 'Pending',
  `pdcreceiptno` varchar(30) NOT NULL DEFAULT '',
  `bank` varchar(50) NOT NULL DEFAULT '',
  `checkno` varchar(30) NOT NULL DEFAULT '',
  `chckreceivedby` varchar(30) NOT NULL DEFAULT '',
  `depository` varchar(30) NOT NULL DEFAULT '',
  `datedep` date DEFAULT NULL,
  `paymentstat` varchar(10) NOT NULL DEFAULT '0',
  `penalty` varchar(30) NOT NULL DEFAULT '0',
  `xtype` varchar(10) NOT NULL DEFAULT 'unselected',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_processedbill
CREATE TABLE `tbltrans_processedbill` (
  `month_period` int(5) DEFAULT NULL,
  `year_period` int(6) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `dateadded` datetime DEFAULT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `gen_xstat` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_processedsoa
CREATE TABLE `tbltrans_processedsoa` (
  `soaNo` varchar(50) NOT NULL DEFAULT '',
  `month_period` int(5) DEFAULT NULL,
  `year_period` int(6) DEFAULT NULL,
  `DueDate` date DEFAULT NULL,
  `dateadded` datetime DEFAULT NULL,
  `gen_xstat` int(2) DEFAULT '0',
  `xstat` int(2) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_procharges
CREATE TABLE `tbltrans_procharges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(30) DEFAULT NULL,
  `ProposalNum` int(5) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `ChargeDesc` varchar(50) DEFAULT NULL,
  `ChargeType` varchar(20) DEFAULT NULL,
  `ChargeAmount` decimal(30,4) DEFAULT '0.0000',
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1176 DEFAULT CHARSET=latin1;


-- Table: tbltrans_procharges_history
CREATE TABLE `tbltrans_procharges_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `ChargeDesc` varchar(50) DEFAULT NULL,
  `ChargeType` varchar(20) DEFAULT NULL,
  `ChargeAmount` decimal(30,4) DEFAULT '0.0000',
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_proposal
CREATE TABLE `tbltrans_proposal` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `proposalNum` tinyint(5) DEFAULT NULL,
  `inquiryID` varchar(30) DEFAULT '',
  `unitID` varchar(30) DEFAULT '',
  `unitType` varchar(15) DEFAULT '',
  `dateFrom` date DEFAULT NULL,
  `dateTo` date DEFAULT NULL,
  `desiredYear` int(11) DEFAULT NULL,
  `desiredMonths` int(11) DEFAULT NULL,
  `desiredDays` int(11) DEFAULT '0',
  `monthlyDues` decimal(30,4) DEFAULT '0.0000',
  `dailyDues` decimal(30,4) DEFAULT '0.0000',
  `assocDues` decimal(30,4) DEFAULT '0.0000',
  `paymentType` varchar(30) DEFAULT '',
  `paymentTerms` varchar(20) DEFAULT '',
  `stats` int(5) DEFAULT '0',
  `escalation_rate` int(11) DEFAULT NULL,
  `year_start` int(11) DEFAULT NULL,
  `year_basis` int(11) DEFAULT NULL,
  `rent_free_construction` int(11) DEFAULT NULL,
  `rent_free_construction_start_date` date DEFAULT NULL,
  `construction_deposit_type` varchar(10) DEFAULT NULL,
  `construction_deposit` decimal(30,4) DEFAULT '0.0000',
  `construction_deposit_terms` int(11) DEFAULT NULL,
  `security_deposit_type` varchar(10) DEFAULT NULL,
  `security_deposit` decimal(30,4) DEFAULT '0.0000',
  `security_deposit_terms` int(11) DEFAULT NULL,
  `exhibit_bond` decimal(30,4) DEFAULT '0.0000',
  `exhibit_terms` int(11) DEFAULT NULL,
  `advance_terms` int(11) DEFAULT NULL,
  `advance_payment` decimal(30,4) DEFAULT '0.0000',
  `payment_schedule` text,
  `charges_list` text,
  `requirement_list` text,
  `permit_list` text,
  `terms_condition` text,
  `terms_condition_group` text,
  `terms_condition_term` text,
  `terms_condition_cond` text,
  `isRent` int(11) DEFAULT '0',
  `vattype` varchar(5) DEFAULT 'inc',
  `vatpercent` int(11) DEFAULT '12',
  `BillingStartDate` date DEFAULT NULL,
  `userid` varchar(30) DEFAULT '',
  `datecreated` date DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `approved_by` varchar(80) DEFAULT NULL,
  `1st_app` varchar(20) DEFAULT '',
  `1st_date` datetime DEFAULT NULL,
  `1st_marks` varchar(150) DEFAULT '',
  `2nd_app` varchar(20) DEFAULT '',
  `2nd_date` datetime DEFAULT NULL,
  `2nd_marks` varchar(150) DEFAULT '',
  `unitArea` decimal(30,4) DEFAULT '0.0000',
  `unitRate` decimal(30,4) DEFAULT '0.0000',
  `isAmendment` tinyint(3) DEFAULT '0',
  `isPrimary` tinyint(3) DEFAULT '0',
  `billingtype` varchar(30) DEFAULT NULL,
  `billingperc` varchar(30) DEFAULT NULL,
  `isDirect` tinyint(5) DEFAULT '0',
  `AmendmentCode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inquiryID` (`inquiryID`)
) ENGINE=InnoDB AUTO_INCREMENT=199 DEFAULT CHARSET=latin1;


-- Table: tbltrans_proposal_history
CREATE TABLE `tbltrans_proposal_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `InquiryID` varchar(30) DEFAULT NULL,
  `DateFrom` date DEFAULT NULL,
  `DateTo` date DEFAULT NULL,
  `NoofDays` varchar(20) DEFAULT NULL,
  `NoofMonths` varchar(20) DEFAULT NULL,
  `NoofYears` varchar(20) DEFAULT NULL,
  `Monthly_Dues` decimal(40,6) DEFAULT '0.000000',
  `Daily_Dues` decimal(40,6) DEFAULT '0.000000',
  `Assoc_Dues` decimal(40,6) DEFAULT '0.000000',
  `PaymentTerms` varchar(20) DEFAULT NULL,
  `Stats` int(5) DEFAULT '0',
  `Escalation_Rate` int(11) DEFAULT NULL,
  `Year_Start` int(11) DEFAULT NULL,
  `Year_Basis` int(11) DEFAULT NULL,
  `Rent_Free_Construction` int(11) DEFAULT NULL,
  `Rent_Free_Construction_Date` date DEFAULT NULL,
  `Construction_Deposit` decimal(30,4) DEFAULT '0.0000',
  `Construction_Deposit_Terms` int(11) DEFAULT NULL,
  `Security_Deposit` decimal(30,4) DEFAULT '0.0000',
  `Security_Deposit_Terms` int(11) DEFAULT NULL,
  `Exhibit_Bond` decimal(30,4) DEFAULT '0.0000',
  `Exhibit_Bond_Terms` int(11) DEFAULT NULL,
  `Advance_Payment` decimal(30,4) DEFAULT '0.0000',
  `Advance_Payment_Terms` int(11) DEFAULT NULL,
  `Charges_List` text,
  `Requirement_List` text,
  `Permit_List` text,
  `isRent` tinyint(5) DEFAULT '0',
  `VatType` varchar(5) DEFAULT 'inc',
  `VatPercent` int(11) DEFAULT '12',
  `BillingStartDate` date DEFAULT NULL,
  `UserID` varchar(30) DEFAULT NULL,
  `DateCreated` date DEFAULT NULL,
  `Date_Approved` datetime DEFAULT NULL,
  `Approved_By` varchar(80) DEFAULT NULL,
  `1st_app` varchar(20) DEFAULT NULL,
  `1st_date` date DEFAULT NULL,
  `1st_marks` varchar(150) DEFAULT NULL,
  `2nd_app` varchar(20) DEFAULT NULL,
  `2nd_date` datetime DEFAULT NULL,
  `2nd_marks` varchar(150) DEFAULT NULL,
  `UnitArea` decimal(30,4) DEFAULT '0.0000',
  `UnitRate` decimal(30,4) DEFAULT '0.0000',
  `isAmendment` tinyint(3) DEFAULT '0',
  `isPrimary` tinyint(3) DEFAULT '0',
  `BillingType` varchar(20) DEFAULT NULL,
  `BillingPerc` varchar(20) DEFAULT NULL,
  `isDirect` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_proposal_pass
CREATE TABLE `tbltrans_proposal_pass` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `ClassID` varchar(20) DEFAULT NULL,
  `DepID` varchar(20) DEFAULT NULL,
  `CatID` varchar(20) DEFAULT NULL,
  `WingID` varchar(20) DEFAULT NULL,
  `FloorID` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `UnitRate` varchar(20) DEFAULT NULL,
  `AssocDues` varchar(20) DEFAULT NULL,
  `Months` int(11) DEFAULT NULL,
  `Percentage` int(11) DEFAULT NULL,
  `DownpaymentType` varchar(20) DEFAULT NULL,
  `Downpayment` decimal(30,4) DEFAULT NULL,
  `OccupancyStartDate` date DEFAULT NULL,
  `isMain` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_proposal_unit
CREATE TABLE `tbltrans_proposal_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tbltrans_proposal_unit_ibfk_1` (`UnitID`),
  CONSTRAINT `tbltrans_proposal_unit_ibfk_1` FOREIGN KEY (`UnitID`) REFERENCES `tblref_unit` (`unitid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=954 DEFAULT CHARSET=latin1;


-- Table: tbltrans_proposal_unit_history
CREATE TABLE `tbltrans_proposal_unit_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ProposalNum` tinyint(5) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_prospects
CREATE TABLE `tbltrans_prospects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ProsID` varchar(20) DEFAULT NULL,
  `ProfileID` varchar(20) DEFAULT NULL,
  `LeadsName` varchar(20) DEFAULT NULL,
  `AssignedPerson` varchar(20) DEFAULT NULL,
  `Position` varchar(20) DEFAULT NULL,
  `Company_Name` varchar(20) DEFAULT NULL,
  `First_Name` varchar(20) DEFAULT NULL,
  `Middle_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(20) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Mobile_No` text,
  `Telephone_No` text,
  `Email` text,
  `Website` text,
  `Remarks` text,
  `source` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Full_Name` text,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_referral
CREATE TABLE `tbltrans_referral` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referralID` varchar(20) DEFAULT NULL,
  `ProfileID` varchar(20) DEFAULT NULL,
  `LeadsName` varchar(20) DEFAULT NULL,
  `AssignedPerson` varchar(20) DEFAULT NULL,
  `Position` varchar(20) DEFAULT NULL,
  `Company_Name` varchar(20) DEFAULT NULL,
  `First_Name` varchar(20) DEFAULT NULL,
  `Middle_Name` varchar(20) DEFAULT NULL,
  `Last_Name` varchar(20) DEFAULT NULL,
  `Birthday` date DEFAULT NULL,
  `Mobile_No` varchar(20) DEFAULT NULL,
  `Telephone_No` varchar(20) DEFAULT NULL,
  `Email` varchar(20) DEFAULT NULL,
  `Website` varchar(20) DEFAULT NULL,
  `Remarks` varchar(20) DEFAULT NULL,
  `source` varchar(20) DEFAULT NULL,
  `Status` varchar(20) DEFAULT NULL,
  `Full_name` varchar(20) DEFAULT NULL,
  `xDATETIME` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_remarks
CREATE TABLE `tbltrans_remarks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `remID` varchar(30) DEFAULT NULL,
  `inqID` varchar(30) DEFAULT NULL,
  `appID` varchar(30) DEFAULT NULL,
  `tenID` varchar(30) DEFAULT NULL,
  `xremarks` text,
  `userID` varchar(30) DEFAULT NULL,
  `xdate` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `sourceid` varchar(30) DEFAULT NULL,
  `xsource` varchar(15) DEFAULT NULL,
  `isRecommendation` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=latin1;


-- Table: tbltrans_remarks_attach
CREATE TABLE `tbltrans_remarks_attach` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RemarksID` varchar(20) DEFAULT NULL,
  `AttachedDoc` varchar(150) DEFAULT NULL,
  `AttachedDocType` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;


-- Table: tbltrans_renew_contract
CREATE TABLE `tbltrans_renew_contract` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RenewalCode` varchar(20) DEFAULT NULL,
  `TenantID` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  `ApplicationID` varchar(20) DEFAULT NULL,
  `mallCompanyID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `BillerID` varchar(20) DEFAULT NULL,
  `TradeID` varchar(20) DEFAULT NULL,
  `Trade_Name` varchar(100) DEFAULT NULL,
  `Company_ID` varchar(20) DEFAULT NULL,
  `Company_Name` varchar(100) DEFAULT NULL,
  `IndustryID` varchar(20) DEFAULT NULL,
  `ClassID` varchar(20) DEFAULT NULL,
  `DepartmentID` varchar(20) DEFAULT NULL,
  `CategoryID` varchar(20) DEFAULT NULL,
  `DateFrom` date DEFAULT NULL,
  `DateTo` date DEFAULT NULL,
  `PaymentTerms` varchar(20) DEFAULT NULL,
  `NoofDays` varchar(20) DEFAULT NULL,
  `NoofMonths` varchar(20) DEFAULT NULL,
  `NoofYears` varchar(20) DEFAULT NULL,
  `Monthly_Dues` decimal(30,4) DEFAULT '0.0000',
  `Daily_Dues` decimal(30,4) DEFAULT '0.0000',
  `Assoc_Dues` decimal(30,4) DEFAULT '0.0000',
  `Esca_Rate` int(11) DEFAULT NULL,
  `Esca_YearStart` int(11) DEFAULT NULL,
  `Esca_YearBasis` int(11) DEFAULT NULL,
  `Rent_Free_Cons` int(11) DEFAULT NULL,
  `Rent_Free_Cons_SD` date DEFAULT NULL,
  `Cons_Dep_Month` int(11) DEFAULT '0',
  `Cons_Dep_Amount` decimal(30,4) DEFAULT '0.0000',
  `Sec_Dep_Month` int(11) DEFAULT '0',
  `Sec_Dep_Amount` decimal(30,4) DEFAULT '0.0000',
  `Exh_Bond_Month` int(11) DEFAULT '0',
  `Exh_Bond_Amount` decimal(30,4) DEFAULT '0.0000',
  `Adv_Month` int(11) DEFAULT '0',
  `Adv_Amount` decimal(30,4) DEFAULT '0.0000',
  `BillingType` varchar(30) DEFAULT NULL,
  `BillingPerc` varchar(5) DEFAULT NULL,
  `Requirement_List` text,
  `Permit_List` text,
  `isRent` int(11) DEFAULT '0',
  `UnitArea` decimal(30,4) DEFAULT '0.0000',
  `UnitRate` decimal(30,4) DEFAULT '0.0000',
  `inqSource` varchar(30) DEFAULT NULL,
  `inqPrcssOwnr` varchar(30) DEFAULT NULL,
  `DateCreated` date DEFAULT NULL,
  `TimeCreated` time DEFAULT NULL,
  `DateTimeCreated` timestamp NULL DEFAULT NULL,
  `appstat` varchar(20) DEFAULT NULL,
  `1st_app` varchar(20) DEFAULT NULL,
  `1st_date` datetime DEFAULT NULL,
  `2nd_app` varchar(20) DEFAULT NULL,
  `2nd_date` datetime DEFAULT NULL,
  `3rd_app` varchar(20) DEFAULT NULL,
  `3rd_date` datetime DEFAULT NULL,
  `date_approved` datetime DEFAULT NULL,
  `userid` varchar(20) DEFAULT NULL,
  `forrenewal` int(1) DEFAULT NULL,
  `renewalstatus` varchar(20) DEFAULT NULL,
  `noticeapprovedate` date DEFAULT NULL,
  `1st_app_renew` varchar(20) DEFAULT NULL,
  `1st_date_renew` datetime DEFAULT NULL,
  `2nd_app_renew` varchar(20) DEFAULT NULL,
  `2nd_date_renew` datetime DEFAULT NULL,
  `3rd_app_renew` varchar(20) DEFAULT NULL,
  `3rd_date_renew` datetime DEFAULT NULL,
  `renewdateapproved` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `isActive` tinyint(5) DEFAULT '0',
  `isNotice` tinyint(5) DEFAULT '0',
  `is2ndNotice` tinyint(5) DEFAULT '0',
  `ContractID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_renew_contract_charges
CREATE TABLE `tbltrans_renew_contract_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RenewalCode` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `ChargeDesc` varchar(50) DEFAULT NULL,
  `ChargeType` varchar(20) DEFAULT NULL,
  `ChargeAmount` decimal(30,4) DEFAULT '0.0000',
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_renew_contract_charges_esca
CREATE TABLE `tbltrans_renew_contract_charges_esca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RenewalCode` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `YearStart` decimal(30,4) DEFAULT '0.0000',
  `YearBasis` decimal(30,4) DEFAULT '0.0000',
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_renew_contract_charges_esca_br
CREATE TABLE `tbltrans_renew_contract_charges_esca_br` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RenewalCode` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ChargeCode` varchar(30) DEFAULT NULL,
  `EscaYear` varchar(30) DEFAULT NULL,
  `EscaStartDate` date DEFAULT NULL,
  `EscaEndDate` date DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `EscaAmount` decimal(30,4) DEFAULT '0.0000',
  `EscaTotal` decimal(30,4) DEFAULT '0.0000',
  `EscaStat` varchar(20) DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_renew_contract_esca
CREATE TABLE `tbltrans_renew_contract_esca` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RenewalCode` varchar(20) DEFAULT NULL,
  `EscaYear` varchar(20) DEFAULT NULL,
  `EscaStartDate` date DEFAULT NULL,
  `EscaEndDate` date DEFAULT NULL,
  `EscaRate` decimal(30,4) DEFAULT '0.0000',
  `AccuEscaRate` decimal(30,4) DEFAULT '0.0000',
  `EscaAmount` decimal(30,4) DEFAULT '0.0000',
  `EscaTotal` decimal(30,4) DEFAULT '0.0000',
  `EscaStat` varchar(20) DEFAULT 'No',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_renew_contract_unit
CREATE TABLE `tbltrans_renew_contract_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RenewalCode` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_reservation
CREATE TABLE `tbltrans_reservation` (
  `id` int(50) NOT NULL AUTO_INCREMENT,
  `transID` varchar(100) DEFAULT NULL,
  `appID` varchar(100) DEFAULT NULL,
  `inqID` varchar(100) DEFAULT NULL,
  `tradename` varchar(100) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `industry` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `compinf_telno` varchar(100) DEFAULT NULL,
  `compinf_faxno` varchar(100) DEFAULT NULL,
  `compinf_email` varchar(100) DEFAULT NULL,
  `compinf_website` varchar(100) DEFAULT NULL,
  `compinf_Franchisor` varchar(100) DEFAULT NULL,
  `compinf_ownerfirstname` varchar(100) DEFAULT NULL,
  `compinf_ownermidname` varchar(100) DEFAULT NULL,
  `compinf_ownerlastname` varchar(100) DEFAULT NULL,
  `compinf_stat` varchar(100) DEFAULT NULL,
  `compinf_address` varchar(100) DEFAULT NULL,
  `contact_firstname` varchar(100) DEFAULT NULL,
  `contact_midname` varchar(100) DEFAULT NULL,
  `contact_lastname` varchar(100) DEFAULT NULL,
  `contact_designation` varchar(100) DEFAULT NULL,
  `contact_mobno` varchar(100) DEFAULT NULL,
  `contact_telno` varchar(100) DEFAULT NULL,
  `merchandise_dep` varchar(100) DEFAULT NULL,
  `dep_id` varchar(100) DEFAULT NULL,
  `merchandise_class` varchar(100) DEFAULT NULL,
  `class_id` varchar(100) DEFAULT NULL,
  `merchandise_cat` varchar(100) DEFAULT NULL,
  `cat_id` varchar(100) DEFAULT NULL,
  `resapp_mall` varchar(100) DEFAULT NULL,
  `mall_id` varchar(100) DEFAULT NULL,
  `resapp_flr` varchar(100) DEFAULT NULL,
  `flr_id` varchar(100) DEFAULT NULL,
  `resapp_wing` varchar(100) DEFAULT NULL,
  `wing_id` varchar(100) DEFAULT NULL,
  `resapp_class` varchar(100) DEFAULT NULL,
  `classification_id` varchar(100) DEFAULT NULL,
  `resapp_unit` varchar(100) DEFAULT NULL,
  `unitID` varchar(100) DEFAULT NULL,
  `datefrom` varchar(100) DEFAULT NULL,
  `dateto` varchar(100) DEFAULT NULL,
  `datepayment` varchar(100) DEFAULT NULL,
  `amount` varchar(100) DEFAULT NULL,
  `alertdate` varchar(100) DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `accof` varchar(100) DEFAULT NULL,
  `alerttype_cus` varchar(100) DEFAULT NULL,
  `alerttype_email` varchar(100) DEFAULT NULL,
  `Status` varchar(100) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenants
CREATE TABLE `tbltrans_tenants` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `mallID` varchar(20) DEFAULT NULL,
  `owner_lastname` varchar(50) DEFAULT NULL,
  `owner_firstname` varchar(50) DEFAULT NULL,
  `owner_midname` varchar(50) DEFAULT NULL,
  `appID` varchar(20) DEFAULT NULL,
  `inqID` varchar(20) DEFAULT NULL,
  `tradeID` varchar(20) DEFAULT NULL,
  `tradename` varchar(100) DEFAULT NULL,
  `CompanyID` varchar(20) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `unitID` varchar(20) DEFAULT NULL,
  `unitname` varchar(50) DEFAULT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT '0',
  `noofmonths` varchar(12) DEFAULT '0',
  `noofdays` varchar(12) DEFAULT '0',
  `ustatus` varchar(20) DEFAULT NULL,
  `dateevic` date DEFAULT NULL,
  `tenanttype` varchar(20) DEFAULT NULL,
  `revpercent` varchar(5) DEFAULT NULL,
  `withPOS` tinyint(1) DEFAULT '0',
  `merchant_code` char(3) DEFAULT NULL,
  `ContractID` varchar(20) DEFAULT NULL,
  `noofyears` int(11) DEFAULT '0',
  `owner_card_number` varchar(30) DEFAULT NULL,
  `depamount` decimal(40,6) DEFAULT '0.000000',
  `uploadingoffiles` tinyint(5) DEFAULT '0',
  `payment_terms` varchar(20) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `cardtype` varchar(20) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `authno` varchar(30) DEFAULT NULL,
  `seccode` varchar(30) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `bankfrom` varchar(20) DEFAULT NULL,
  `bf_accno` varchar(30) DEFAULT NULL,
  `bankto` varchar(20) DEFAULT NULL,
  `bt_accno` varchar(30) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `monthly_dues` decimal(40,6) DEFAULT '0.000000',
  `daily_dues` decimal(40,6) DEFAULT '0.000000',
  `assoc_dues` decimal(40,6) DEFAULT '0.000000',
  `def_password` varchar(50) DEFAULT 'password',
  `def_password2` varchar(50) DEFAULT '5f4dcc3b5aa765d61d8327deb882cf99',
  `Contract_NumSAP` varchar(50) DEFAULT NULL,
  `Company_CodeSAP` varchar(50) DEFAULT NULL,
  `SFTP_User` varchar(30) DEFAULT NULL,
  `SFTP_Pass` varchar(30) DEFAULT NULL,
  `TP_Setup` varchar(20) DEFAULT NULL,
  `LMRWater` date DEFAULT NULL,
  `LMRElectric` date DEFAULT NULL,
  `LMRGas` date DEFAULT NULL,
  `mallCompanyID` varchar(30) DEFAULT NULL,
  `ClassID` varchar(30) DEFAULT NULL,
  `DepartmentID` varchar(30) DEFAULT NULL,
  `CategoryID` varchar(30) DEFAULT NULL,
  `inqSource` varchar(30) DEFAULT NULL,
  `inqPrcssOwnr` varchar(30) DEFAULT NULL,
  `BillerID` varchar(20) DEFAULT NULL,
  `ActiveProposal` tinyint(5) DEFAULT '1',
  `isDirect` tinyint(5) DEFAULT '0',
  `JDATenant_Code` varchar(30) DEFAULT NULL,
  `isVendor` tinyint(5) DEFAULT '0',
  `VendorCode` varchar(30) DEFAULT NULL,
  `VendorLocation` varchar(80) DEFAULT NULL,
  `JDA_Comp_ID` varchar(30) DEFAULT NULL,
  `Beg_Date` date DEFAULT NULL,
  `Beg_Balance` decimal(30,4) DEFAULT '0.0000',
  `RenewalCode` varchar(20) DEFAULT NULL,
  `AmendmentCode` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_companyname` (`companyname`(30)),
  KEY `IDX_datefrom` (`datefrom`),
  KEY `IDX_dateto` (`dateto`),
  KEY `IDX_merchant_code` (`merchant_code`),
  KEY `IDX_OwnerFirstName` (`owner_firstname`(20)),
  KEY `IDX_OwnerLastName` (`owner_lastname`(20)),
  KEY `IDX_OwnerMiddleName` (`owner_midname`(20)),
  KEY `IDX_Status` (`Status`(10)),
  KEY `IDX_tradename` (`tradename`(30)),
  KEY `IDX_UnitID` (`unitID`),
  KEY `IDX_UStatus` (`ustatus`(10)),
  KEY `IDX_MallID` (`mallID`(10)),
  KEY `mallCompanyID` (`mallCompanyID`),
  KEY `CompanyID` (`CompanyID`),
  KEY `tradeID` (`tradeID`),
  KEY `inqPrcssOwnr` (`inqPrcssOwnr`),
  KEY `BillerID` (`BillerID`),
  KEY `DepartmentID` (`DepartmentID`),
  KEY `ClassID` (`ClassID`),
  KEY `CategoryID` (`CategoryID`),
  KEY `mallID` (`mallID`),
  KEY `inqID` (`inqID`),
  CONSTRAINT `tbltrans_tenants_ibfk_11` FOREIGN KEY (`mallCompanyID`) REFERENCES `tblref_mallcompany` (`MallCompanyID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_2` FOREIGN KEY (`CompanyID`) REFERENCES `tbltrans_company` (`CompanyID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_3` FOREIGN KEY (`tradeID`) REFERENCES `tbltrans_tradename` (`tradeID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_4` FOREIGN KEY (`inqPrcssOwnr`) REFERENCES `tblref_process_owner` (`deptCode`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_5` FOREIGN KEY (`BillerID`) REFERENCES `tblref_billprofile` (`BillerID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_6` FOREIGN KEY (`DepartmentID`) REFERENCES `tblref_merchandise_depa` (`departmentID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_7` FOREIGN KEY (`ClassID`) REFERENCES `tblref_merchandise_class` (`classificationID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_8` FOREIGN KEY (`CategoryID`) REFERENCES `tblref_merchandisedep_cat` (`categoryID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  CONSTRAINT `tbltrans_tenants_ibfk_9` FOREIGN KEY (`mallID`) REFERENCES `tblref_mall` (`mallid`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenants_copy
CREATE TABLE `tbltrans_tenants_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) NOT NULL,
  `mallID` varchar(20) DEFAULT NULL,
  `owner_lastname` varchar(50) DEFAULT NULL,
  `owner_firstname` varchar(50) DEFAULT NULL,
  `owner_midname` varchar(50) DEFAULT NULL,
  `appID` varchar(20) DEFAULT NULL,
  `inqID` varchar(20) DEFAULT NULL,
  `tradeID` varchar(20) DEFAULT NULL,
  `tradename` varchar(100) DEFAULT NULL,
  `CompanyID` varchar(20) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `unitID` varchar(20) DEFAULT NULL,
  `unitname` varchar(50) DEFAULT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `Status` varchar(20) DEFAULT '0',
  `noofmonths` varchar(12) DEFAULT '0',
  `noofdays` varchar(12) DEFAULT '0',
  `ustatus` varchar(20) DEFAULT NULL,
  `dateevic` date DEFAULT NULL,
  `tenanttype` varchar(20) DEFAULT NULL,
  `revpercent` varchar(5) DEFAULT NULL,
  `withPOS` tinyint(1) DEFAULT '0',
  `merchant_code` char(3) DEFAULT NULL,
  `ContractID` varchar(20) DEFAULT NULL,
  `noofyears` int(11) DEFAULT '0',
  `owner_card_number` varchar(30) DEFAULT NULL,
  `depamount` decimal(40,6) DEFAULT '0.000000',
  `uploadingoffiles` tinyint(5) DEFAULT '0',
  `payment_terms` varchar(20) DEFAULT NULL,
  `payment_type` varchar(20) DEFAULT NULL,
  `cardtype` varchar(20) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `authno` varchar(30) DEFAULT NULL,
  `seccode` varchar(30) DEFAULT NULL,
  `expirydate` varchar(20) DEFAULT NULL,
  `bankfrom` varchar(20) DEFAULT NULL,
  `bf_accno` varchar(30) DEFAULT NULL,
  `bankto` varchar(20) DEFAULT NULL,
  `bt_accno` varchar(30) DEFAULT NULL,
  `account_number` varchar(20) DEFAULT NULL,
  `monthly_dues` decimal(40,6) DEFAULT '0.000000',
  `daily_dues` decimal(40,6) DEFAULT '0.000000',
  `assoc_dues` decimal(40,6) DEFAULT '0.000000',
  `def_password` varchar(50) DEFAULT 'password',
  `def_password2` varchar(50) DEFAULT '5f4dcc3b5aa765d61d8327deb882cf99',
  `Contract_NumSAP` varchar(50) DEFAULT NULL,
  `Company_CodeSAP` varchar(50) DEFAULT NULL,
  `SFTP_User` varchar(30) DEFAULT NULL,
  `SFTP_Pass` varchar(30) DEFAULT NULL,
  `TP_Setup` varchar(20) DEFAULT NULL,
  `LMRWater` date DEFAULT NULL,
  `LMRElectric` date DEFAULT NULL,
  `LMRGas` date DEFAULT NULL,
  `mallCompanyID` varchar(30) DEFAULT NULL,
  `ClassID` varchar(30) DEFAULT NULL,
  `DepartmentID` varchar(30) DEFAULT NULL,
  `CategoryID` varchar(30) DEFAULT NULL,
  `inqSource` varchar(30) DEFAULT NULL,
  `inqPrcssOwnr` varchar(30) DEFAULT NULL,
  `BillerID` varchar(20) DEFAULT NULL,
  `ActiveProposal` tinyint(5) DEFAULT '1',
  `isDirect` tinyint(5) DEFAULT '0',
  `JDATenant_Code` varchar(30) DEFAULT NULL,
  `isVendor` tinyint(5) DEFAULT '0',
  `VendorCode` varchar(30) DEFAULT NULL,
  `VendorLocation` varchar(80) DEFAULT NULL,
  `JDA_Comp_ID` varchar(30) DEFAULT NULL,
  `Beg_Date` date DEFAULT NULL,
  `Beg_Balance` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`TenantID`(15)),
  UNIQUE KEY `id` (`id`),
  KEY `IDX_companyname` (`companyname`(30)),
  KEY `IDX_datefrom` (`datefrom`),
  KEY `IDX_dateto` (`dateto`),
  KEY `IDX_merchant_code` (`merchant_code`),
  KEY `IDX_OwnerFirstName` (`owner_firstname`(20)),
  KEY `IDX_OwnerLastName` (`owner_lastname`(20)),
  KEY `IDX_OwnerMiddleName` (`owner_midname`(20)),
  KEY `IDX_Status` (`Status`(10)),
  KEY `IDX_tradename` (`tradename`(30)),
  KEY `IDX_UnitID` (`unitID`),
  KEY `IDX_UStatus` (`ustatus`(10)),
  KEY `IDX_MallID` (`mallID`(10)),
  KEY `mallCompanyID` (`mallCompanyID`),
  KEY `CompanyID` (`CompanyID`),
  KEY `tradeID` (`tradeID`),
  KEY `inqPrcssOwnr` (`inqPrcssOwnr`),
  KEY `BillerID` (`BillerID`),
  KEY `DepartmentID` (`DepartmentID`),
  KEY `ClassID` (`ClassID`),
  KEY `CategoryID` (`CategoryID`),
  KEY `mallID` (`mallID`),
  KEY `inqID` (`inqID`)
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenants_dummy
CREATE TABLE `tbltrans_tenants_dummy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `mallID` varchar(20) DEFAULT NULL,
  `owner_lastname` varchar(50) DEFAULT NULL,
  `owner_firstname` varchar(50) DEFAULT NULL,
  `owner_midname` varchar(50) DEFAULT NULL,
  `appID` varchar(20) DEFAULT NULL,
  `inqID` varchar(20) DEFAULT NULL,
  `tradeID` varchar(20) DEFAULT NULL,
  `tradename` varchar(100) DEFAULT NULL,
  `CompanyID` varchar(20) DEFAULT NULL,
  `companyname` varchar(100) DEFAULT NULL,
  `unitID` varchar(20) DEFAULT NULL,
  `unitname` varchar(50) NOT NULL,
  `datefrom` date DEFAULT NULL,
  `dateto` date DEFAULT NULL,
  `datepayment` varchar(30) DEFAULT NULL,
  `amount` varchar(30) DEFAULT NULL,
  `alertdate` varchar(30) DEFAULT NULL,
  `remarks` varchar(30) DEFAULT NULL,
  `accof` varchar(30) DEFAULT NULL,
  `alerttype_cus` varchar(30) DEFAULT NULL,
  `alerttype_email` varchar(30) DEFAULT NULL,
  `Status` varchar(20) DEFAULT '0',
  `noofmonths` varchar(12) DEFAULT NULL,
  `noofdays` varchar(12) DEFAULT NULL,
  `costpermonths` double(40,2) DEFAULT '0.00',
  `ustatus` varchar(20) DEFAULT NULL,
  `billing_type` varchar(30) DEFAULT NULL,
  `dateevic` date DEFAULT NULL,
  `tenanttype` varchar(20) DEFAULT NULL,
  `revpercent` varchar(5) DEFAULT NULL,
  `withPOS` tinyint(1) DEFAULT '0',
  `merchant_code` char(3) DEFAULT NULL,
  `contractID` varchar(30) DEFAULT NULL,
  `owner_card_number` varchar(50) DEFAULT NULL,
  `tenantphoto` varchar(50) DEFAULT NULL,
  `depamount` double(40,2) DEFAULT '0.00',
  `advamount` double(40,2) DEFAULT '0.00',
  `depmonth` int(4) DEFAULT '0',
  `advmonth` int(4) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenants_history
CREATE TABLE `tbltrans_tenants_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `ApplicationID` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  `TradeID` varchar(20) DEFAULT NULL,
  `TradeName` varchar(100) DEFAULT NULL,
  `CompanyID` varchar(20) DEFAULT NULL,
  `CompanyName` varchar(100) DEFAULT NULL,
  `DateFrom` date DEFAULT NULL,
  `DateTo` date DEFAULT NULL,
  `Status` varchar(30) DEFAULT NULL,
  `NoofDays` varchar(20) DEFAULT NULL,
  `NoofMonths` varchar(20) DEFAULT NULL,
  `NoofYears` varchar(20) DEFAULT NULL,
  `OccupancyStatus` varchar(30) DEFAULT NULL,
  `BillingType` varchar(30) DEFAULT NULL,
  `BillingPercent` varchar(5) DEFAULT NULL,
  `NumberofPOS` tinyint(8) DEFAULT '0',
  `MerchantCode` char(5) DEFAULT NULL,
  `AllowCSVUpload` tinyint(3) DEFAULT '0',
  `ContractID` varchar(20) DEFAULT NULL,
  `PaymentTerms` varchar(20) DEFAULT NULL,
  `Monthly_Dues` decimal(40,6) DEFAULT '0.000000',
  `Daily_Dues` decimal(40,6) DEFAULT '0.000000',
  `Assoc_Dues` decimal(40,6) DEFAULT '0.000000',
  `TPS_Password` varchar(50) DEFAULT NULL,
  `TPS_PasswordH` varchar(50) DEFAULT NULL,
  `SFTP_User` varchar(30) DEFAULT NULL,
  `SFTP_Password` varchar(30) DEFAULT NULL,
  `TP_Setup` varchar(20) DEFAULT NULL,
  `LMRWater` date DEFAULT NULL,
  `LMRElectric` date DEFAULT NULL,
  `LMRGas` date DEFAULT NULL,
  `MallCompanyID` varchar(20) DEFAULT NULL,
  `ClassID` varchar(20) DEFAULT NULL,
  `DepartmentID` varchar(20) DEFAULT NULL,
  `CategoryID` varchar(20) DEFAULT NULL,
  `inqSource` varchar(20) DEFAULT NULL,
  `inqPrcssOwnr` varchar(20) DEFAULT NULL,
  `BillerID` varchar(20) DEFAULT NULL,
  `ActiveProposal` tinyint(5) DEFAULT NULL,
  `isDirect` tinyint(5) DEFAULT '0',
  `JDATenant_Code` varchar(30) DEFAULT NULL,
  `isVendor` tinyint(5) DEFAULT NULL,
  `VendorCode` varchar(30) DEFAULT NULL,
  `VendorLocation` varchar(80) DEFAULT NULL,
  `JDA_Comp_ID` varchar(30) DEFAULT NULL,
  `Beg_Date` date DEFAULT NULL,
  `Beg_Balance` decimal(30,4) DEFAULT '0.0000',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenantsrequest
CREATE TABLE `tbltrans_tenantsrequest` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TenantID` varchar(20) DEFAULT NULL,
  `RequestID` varchar(20) DEFAULT NULL,
  `ApplicationDate` date DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `APPROVAL_STATUS` int(20) DEFAULT '0',
  `APPROVAL_STAGE` int(20) DEFAULT '1',
  `APP_STATUS` varchar(20) DEFAULT 'Pending',
  `RequestCat` varchar(20) DEFAULT NULL,
  `RequestTag` varchar(20) DEFAULT NULL,
  `Remarks` varchar(255) DEFAULT NULL,
  `isApproval` int(11) DEFAULT NULL,
  `notify` int(1) DEFAULT '0',
  `xuser` varchar(20) DEFAULT '',
  `1st_app` varchar(20) DEFAULT '',
  `1st_date` datetime DEFAULT NULL,
  `1st_marks` varchar(100) DEFAULT '',
  `2ns_app` varchar(20) DEFAULT '',
  `2nd_date` datetime DEFAULT NULL,
  `2nd_marks` varchar(100) DEFAULT '',
  `dateapproved` datetime DEFAULT NULL,
  `lastapproved` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenantsrequest_items
CREATE TABLE `tbltrans_tenantsrequest_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RequestID` varchar(20) DEFAULT '',
  `qty` decimal(10,4) DEFAULT NULL,
  `unitx` varchar(20) DEFAULT '',
  `notes` varchar(200) DEFAULT '',
  `itemname` varchar(200) DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_tenantsrequest_visitor
CREATE TABLE `tbltrans_tenantsrequest_visitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `RequestID` varchar(20) DEFAULT '',
  `fname` varchar(50) DEFAULT '',
  `lname` varchar(50) DEFAULT '',
  `idpres` varchar(150) DEFAULT '',
  `login` time DEFAULT NULL,
  `logout` time DEFAULT NULL,
  `ximage` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltrans_trade_contact_person
CREATE TABLE `tbltrans_trade_contact_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `TradeID` varchar(20) DEFAULT NULL,
  `FirstName` varchar(30) DEFAULT NULL,
  `MiddleName` varchar(30) DEFAULT NULL,
  `LastName` varchar(30) DEFAULT NULL,
  `ContactID` varchar(20) DEFAULT NULL,
  `FullName` varchar(80) DEFAULT NULL,
  `Designation` varchar(30) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `isActive` int(11) DEFAULT '1',
  `isPrimary` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=216 DEFAULT CHARSET=latin1;


-- Table: tbltrans_trade_contact_person_list
CREATE TABLE `tbltrans_trade_contact_person_list` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ContactID` varchar(30) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `content` varchar(30) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=717 DEFAULT CHARSET=latin1;


-- Table: tbltrans_tradename
CREATE TABLE `tbltrans_tradename` (
  `tradeID` varchar(20) DEFAULT NULL,
  `tradename` varchar(100) DEFAULT NULL,
  `companyID` varchar(20) DEFAULT NULL,
  `BusinessAddress` varchar(255) DEFAULT NULL,
  `filename` text,
  `merchant_code` varchar(20) DEFAULT NULL,
  `automerchant_code` varchar(20) DEFAULT NULL,
  `BillSetup` varchar(20) DEFAULT NULL,
  `BillID` varchar(30) DEFAULT NULL,
  `MallID` varchar(30) DEFAULT NULL,
  KEY `IDX_TradeID` (`tradeID`),
  KEY `IDX_TradeName` (`tradename`(30)),
  KEY `IDX_MerchantCode` (`merchant_code`(4))
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltransaction
CREATE TABLE `tbltransaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(20) NOT NULL,
  `xcode` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `amount` decimal(40,2) NOT NULL DEFAULT '0.00',
  `qty` decimal(40,2) NOT NULL DEFAULT '0.00',
  `paymentamount` decimal(40,2) DEFAULT '0.00',
  `paymentor` varchar(30) DEFAULT NULL,
  `vatamount` decimal(40,2) DEFAULT '0.00',
  `balance` decimal(40,2) DEFAULT '0.00',
  `xdate` date DEFAULT NULL,
  `transdate` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isPenalty` int(1) DEFAULT '0',
  `paymenttype` varchar(15) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `ccno` varchar(30) DEFAULT NULL,
  `expdate` varchar(10) DEFAULT NULL,
  `checkno` varchar(30) DEFAULT NULL,
  `checkdate` date DEFAULT NULL,
  `checkname` varchar(50) DEFAULT NULL,
  `bankname` varchar(20) DEFAULT NULL,
  `cardtype` varchar(50) DEFAULT NULL,
  `authno` varchar(10) DEFAULT NULL,
  `secno` varchar(10) DEFAULT NULL,
  `orno` varchar(20) DEFAULT NULL,
  `totalamount` decimal(40,2) DEFAULT '0.00',
  `tenanttype` varchar(20) DEFAULT NULL,
  `revpercent` varchar(5) DEFAULT NULL,
  `bnkfrom` varchar(50) DEFAULT NULL,
  `bnkto` varchar(50) DEFAULT NULL,
  `accnofrom` varchar(50) DEFAULT NULL,
  `accnoto` varchar(50) DEFAULT NULL,
  `xdescription` varchar(150) DEFAULT NULL,
  `userid` varchar(50) DEFAULT NULL,
  `Machine_No` varchar(30) DEFAULT NULL,
  `isdeposit` int(5) DEFAULT '0',
  `image_file_name` varchar(100) DEFAULT NULL,
  `isMerchant` int(10) DEFAULT '0',
  `merchant_code` varchar(10) DEFAULT NULL,
  `isPosted` int(1) DEFAULT '0',
  `SoAID` varchar(40) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  `isAdjustment` tinyint(5) DEFAULT '0',
  `isRefund` tinyint(5) DEFAULT '0',
  `isGenerated` tinyint(5) DEFAULT '0',
  KEY `IDX_xdate` (`xdate`),
  KEY `id` (`id`),
  KEY `IDX_TenantID` (`tenantid`)
) ENGINE=InnoDB AUTO_INCREMENT=207 DEFAULT CHARSET=latin1;


-- Table: tbltransaction_
CREATE TABLE `tbltransaction_` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(20) NOT NULL,
  `xcode` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `amount` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `qty` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `paymentamount` decimal(30,6) DEFAULT '0.000000',
  `paymentor` varchar(30) DEFAULT NULL,
  `vatamount` decimal(30,6) DEFAULT '0.000000',
  `balance` decimal(30,6) DEFAULT '0.000000',
  `xdate` date DEFAULT NULL,
  `transdate` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `xdatetime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `isPenalty` int(1) DEFAULT '0',
  `paymenttype` varchar(15) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `ccno` varchar(30) DEFAULT NULL,
  `expdate` varchar(10) DEFAULT NULL,
  `checkno` varchar(30) DEFAULT NULL,
  `checkdate` date DEFAULT NULL,
  `checkname` varchar(50) DEFAULT NULL,
  `bankname` varchar(20) DEFAULT NULL,
  `cardtype` varchar(50) DEFAULT NULL,
  `authno` varchar(10) DEFAULT NULL,
  `secno` varchar(10) DEFAULT NULL,
  `orno` varchar(20) DEFAULT NULL,
  `totalamount` decimal(30,6) DEFAULT '0.000000',
  `tenanttype` varchar(20) DEFAULT NULL,
  `revpercent` varchar(5) DEFAULT NULL,
  `bnkfrom` varchar(50) DEFAULT NULL,
  `bnkto` varchar(50) DEFAULT NULL,
  `accnofrom` varchar(50) DEFAULT NULL,
  `accnoto` varchar(50) DEFAULT NULL,
  `xdescription` varchar(150) DEFAULT NULL,
  `userid` varchar(50) DEFAULT NULL,
  `Machine_No` varchar(30) DEFAULT NULL,
  `isdeposit` int(5) DEFAULT '0',
  `image_file_name` varchar(100) DEFAULT NULL,
  `isMerchant` int(10) DEFAULT '0',
  `merchant_code` varchar(10) DEFAULT NULL,
  `isPosted` int(1) DEFAULT '0',
  `SoAID` varchar(40) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  `isAdjustment` tinyint(5) DEFAULT '0',
  `isRefund` tinyint(5) DEFAULT '0',
  `isGenerated` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `IDX_xdate` (`xdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltransaction_1127
CREATE TABLE `tbltransaction_1127` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(20) NOT NULL,
  `xcode` varchar(80) NOT NULL,
  `description` varchar(150) NOT NULL,
  `amount` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `qty` decimal(30,6) NOT NULL DEFAULT '0.000000',
  `paymentamount` decimal(30,6) DEFAULT '0.000000',
  `paymentor` varchar(30) DEFAULT NULL,
  `vatamount` decimal(30,6) DEFAULT '0.000000',
  `balance` decimal(30,6) DEFAULT '0.000000',
  `xdate` date DEFAULT NULL,
  `transdate` date DEFAULT NULL,
  `reference` varchar(100) DEFAULT NULL,
  `xdatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isPenalty` int(1) DEFAULT '0',
  `paymenttype` varchar(15) DEFAULT NULL,
  `cardholder` varchar(50) DEFAULT NULL,
  `ccno` varchar(30) DEFAULT NULL,
  `expdate` varchar(10) DEFAULT NULL,
  `checkno` varchar(30) DEFAULT NULL,
  `checkdate` date DEFAULT NULL,
  `checkname` varchar(50) DEFAULT NULL,
  `bankname` varchar(20) DEFAULT NULL,
  `cardtype` varchar(50) DEFAULT NULL,
  `authno` varchar(10) DEFAULT NULL,
  `secno` varchar(10) DEFAULT NULL,
  `orno` varchar(20) DEFAULT NULL,
  `totalamount` decimal(30,6) DEFAULT '0.000000',
  `tenanttype` varchar(20) DEFAULT NULL,
  `revpercent` varchar(5) DEFAULT NULL,
  `bnkfrom` varchar(50) DEFAULT NULL,
  `bnkto` varchar(50) DEFAULT NULL,
  `accnofrom` varchar(50) DEFAULT NULL,
  `accnoto` varchar(50) DEFAULT NULL,
  `xdescription` varchar(150) DEFAULT NULL,
  `userid` varchar(50) DEFAULT NULL,
  `Machine_No` varchar(30) DEFAULT NULL,
  `isdeposit` int(5) DEFAULT '0',
  `image_file_name` varchar(100) DEFAULT NULL,
  `isMerchant` int(10) DEFAULT '0',
  `merchant_code` varchar(10) DEFAULT NULL,
  `isPosted` int(1) DEFAULT '0',
  `SoAID` varchar(40) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `InquiryID` varchar(20) DEFAULT NULL,
  `isAdjustment` tinyint(5) DEFAULT '0',
  `isRefund` tinyint(5) DEFAULT '0',
  `isGenerated` tinyint(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `IDX_xdate` (`xdate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltransaction_copy
CREATE TABLE `tbltransaction_copy` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(20) NOT NULL DEFAULT '',
  `xcode` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(50) NOT NULL DEFAULT '',
  `amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `qty` int(11) NOT NULL DEFAULT '0',
  `paymentamount` decimal(15,2) DEFAULT '0.00',
  `vatamount` decimal(15,2) DEFAULT '0.00',
  `balance` decimal(15,2) DEFAULT '0.00',
  `xdate` date NOT NULL,
  `reference` varchar(100) NOT NULL DEFAULT '',
  `xdatetime` datetime NOT NULL,
  `xpenalty` varchar(10) NOT NULL DEFAULT '',
  `xpenaltystatus` int(1) NOT NULL DEFAULT '0',
  `paymenttype` varchar(15) NOT NULL DEFAULT '',
  `cardholder` varchar(50) NOT NULL DEFAULT '',
  `ccno` varchar(30) NOT NULL DEFAULT '',
  `expdate` varchar(15) NOT NULL DEFAULT '',
  `checkno` varchar(30) NOT NULL DEFAULT '',
  `checkdate` date NOT NULL,
  `checkname` varchar(50) NOT NULL DEFAULT '',
  `bankname` varchar(20) NOT NULL DEFAULT '',
  `cardtype` varchar(50) DEFAULT '',
  `authno` varchar(10) DEFAULT '',
  `secno` varchar(10) DEFAULT '',
  `orno` varchar(20) NOT NULL DEFAULT '',
  `totalamount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `charges_status` varchar(20) NOT NULL DEFAULT '',
  `tenanttype` varchar(20) NOT NULL DEFAULT '',
  `revpercent` varchar(5) NOT NULL DEFAULT '',
  `revamount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `bnkfrom` varchar(50) DEFAULT '',
  `bnkto` varchar(50) DEFAULT '',
  `accnofrom` varchar(50) DEFAULT '',
  `accnoto` varchar(50) DEFAULT '',
  `xdescription` varchar(50) DEFAULT '',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltransaction_soa
CREATE TABLE `tbltransaction_soa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tenantid` varchar(20) NOT NULL DEFAULT '',
  `xcode` varchar(20) NOT NULL DEFAULT '',
  `description` varchar(50) NOT NULL DEFAULT '',
  `amount` decimal(15,6) NOT NULL DEFAULT '0.000000',
  `qty` int(11) NOT NULL DEFAULT '0',
  `paymentamount` decimal(15,6) DEFAULT '0.000000',
  `vatamount` decimal(15,6) DEFAULT '0.000000',
  `balance` decimal(15,6) DEFAULT '0.000000',
  `xdate` date NOT NULL,
  `reference` varchar(100) NOT NULL DEFAULT '',
  `xdatetime` datetime NOT NULL,
  `xpenalty` varchar(10) NOT NULL DEFAULT '',
  `xpenaltystatus` int(1) NOT NULL DEFAULT '0',
  `paymenttype` varchar(15) NOT NULL DEFAULT '',
  `cardholder` varchar(50) NOT NULL DEFAULT '',
  `ccno` varchar(30) NOT NULL DEFAULT '',
  `expdate` varchar(15) NOT NULL DEFAULT '',
  `checkno` varchar(30) NOT NULL DEFAULT '',
  `checkdate` date NOT NULL,
  `checkname` varchar(50) NOT NULL DEFAULT '',
  `bankname` varchar(20) NOT NULL DEFAULT '',
  `cardtype` varchar(50) DEFAULT '',
  `authno` varchar(10) DEFAULT '',
  `secno` varchar(10) DEFAULT '',
  `orno` varchar(20) NOT NULL DEFAULT '',
  `totalamount` decimal(15,6) NOT NULL DEFAULT '0.000000',
  `charges_status` varchar(20) NOT NULL DEFAULT '',
  `tenanttype` varchar(20) NOT NULL DEFAULT '',
  `revpercent` varchar(5) NOT NULL DEFAULT '',
  `revamount` decimal(15,6) NOT NULL DEFAULT '0.000000',
  `bnkfrom` varchar(50) DEFAULT '',
  `bnkto` varchar(50) DEFAULT '',
  `accnofrom` varchar(50) DEFAULT '',
  `accnoto` varchar(50) DEFAULT '',
  `xdescription` varchar(50) DEFAULT '',
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltransleasing_contactlist
CREATE TABLE `tbltransleasing_contactlist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(50) DEFAULT NULL,
  `FirstName` varchar(50) DEFAULT NULL,
  `MiddleName` varchar(50) DEFAULT NULL,
  `LastName` varchar(50) DEFAULT NULL,
  `CompanyPosition` varchar(30) DEFAULT NULL,
  `Address` text,
  `EmailAddress` varchar(50) DEFAULT NULL,
  `MobileNo` varchar(30) DEFAULT NULL,
  `TelephoneNo` varchar(30) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbltransleasing_inquiry
CREATE TABLE `tbltransleasing_inquiry` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `InquiryID` varchar(20) DEFAULT NULL,
  `Date_Inquired` date DEFAULT NULL,
  `ApplicationID` varchar(20) DEFAULT NULL,
  `Date_Applied` date DEFAULT NULL,
  `Date_Dissapproved` date DEFAULT NULL,
  `TenantID` varchar(20) DEFAULT NULL,
  `MallID` varchar(20) DEFAULT NULL,
  `WingID` varchar(20) DEFAULT NULL,
  `FloorID` varchar(20) DEFAULT NULL,
  `UnitID` varchar(20) DEFAULT NULL,
  `ClassificationID` varchar(20) DEFAULT NULL,
  `DepartmentID` varchar(20) DEFAULT NULL,
  `CategoryID` varchar(20) DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Middle_Name` varchar(50) DEFAULT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `Fullname` varchar(100) DEFAULT NULL,
  `Gender` varchar(20) DEFAULT NULL,
  `Birthdate` date DEFAULT NULL,
  `Civil_Status` varchar(30) DEFAULT NULL,
  `Telephone_No` varchar(30) DEFAULT NULL,
  `Mobile_No` varchar(30) DEFAULT NULL,
  `EmailAddress` varchar(30) DEFAULT NULL,
  `TIN` varchar(20) DEFAULT NULL,
  `Occupation` varchar(30) DEFAULT NULL,
  `Citizenship` varchar(30) DEFAULT NULL,
  `Address` text,
  `City` varchar(30) DEFAULT NULL,
  `Country` varchar(30) DEFAULT NULL,
  `ZipCode` varchar(20) DEFAULT NULL,
  `Unit_Area` varchar(30) DEFAULT NULL,
  `Price_Per_SQM` decimal(15,2) DEFAULT NULL,
  `MonthlyDue` decimal(15,2) DEFAULT '0.00',
  `OccupancyDateFrom` date DEFAULT NULL,
  `OccupancyDateTo` date DEFAULT NULL,
  `OccupancyMonthCount` varchar(20) DEFAULT '0',
  `AssociationDue` decimal(15,2) DEFAULT '0.00',
  `ListPrice` decimal(15,2) DEFAULT '0.00',
  `PromoDiscount` decimal(15,2) DEFAULT '0.00',
  `CompanyDiscount` decimal(15,2) DEFAULT '0.00',
  `SpotDownPayment` decimal(15,2) DEFAULT '0.00',
  `SpotDownPaymentDue` date DEFAULT NULL,
  `ReservationFee` decimal(15,2) DEFAULT '0.00',
  `ReservationFeeDue` date DEFAULT NULL,
  `RetentionFee` decimal(15,2) DEFAULT '0.00',
  `NetSpotPayment` decimal(15,2) DEFAULT '0.00',
  `NetDownPayment` decimal(15,2) DEFAULT '0.00',
  `AmortNoOfMonths` int(10) DEFAULT NULL,
  `AmortStartDate` date DEFAULT NULL,
  `MonthlyAmort` decimal(15,6) DEFAULT '0.000000',
  `Balance` decimal(15,6) DEFAULT '0.000000',
  `PaymentType` varchar(30) DEFAULT NULL,
  `ValidityOfPaymentScheme` date DEFAULT NULL,
  `PaymentScheme` varbinary(100) DEFAULT NULL,
  `SourceOfSale` varchar(100) DEFAULT NULL,
  `Reason4Buying` varchar(100) DEFAULT NULL,
  `TermsAndCondition` text,
  `Status` varchar(20) DEFAULT 'Inquired',
  `UserID` varchar(20) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblunit_statuslogs
CREATE TABLE `tblunit_statuslogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitid` varchar(20) DEFAULT NULL,
  `unitname` varchar(100) DEFAULT NULL,
  `tenantid` varchar(20) DEFAULT NULL,
  `tenantname` varchar(100) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `electricstat` tinyint(1) DEFAULT '0',
  `waterstat` tinyint(1) DEFAULT '0',
  `txtstat` tinyint(1) DEFAULT '0',
  `xstat` int(2) DEFAULT '0',
  `gasstat` tinyint(1) DEFAULT '0',
  `inquiryid` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unitid` (`unitid`(11)),
  KEY `unitname` (`unitname`),
  KEY `xdate` (`xdate`),
  KEY `tenantid` (`tenantid`(11)),
  KEY `status` (`status`(11)),
  KEY `unitid_2` (`unitid`),
  CONSTRAINT `tblunit_statuslogs_ibfk_1` FOREIGN KEY (`unitid`) REFERENCES `tblref_unit` (`unitid`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=367 DEFAULT CHARSET=latin1;


-- Table: tblunit_statuslogs_blanck
CREATE TABLE `tblunit_statuslogs_blanck` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unitid` varchar(20) DEFAULT NULL,
  `unitname` varchar(200) DEFAULT NULL,
  `tenantid` varchar(20) DEFAULT NULL,
  `tenantname` varchar(200) DEFAULT NULL,
  `xdate` date DEFAULT NULL,
  `xtime` time DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `electricstat` tinyint(1) DEFAULT '0',
  `waterstat` tinyint(1) DEFAULT '0',
  `txtstat` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tbluser
CREATE TABLE `tbluser` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` varchar(20) DEFAULT NULL,
  `firstname` varchar(50) DEFAULT NULL,
  `middlename` varchar(50) DEFAULT NULL,
  `lastname` varchar(50) DEFAULT NULL,
  `contactnumber` varchar(20) DEFAULT NULL,
  `emailaddress` varchar(30) DEFAULT NULL,
  `gender` varchar(30) DEFAULT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `ext` varchar(100) DEFAULT NULL,
  `dateadded` date DEFAULT NULL,
  `groupaccess` varchar(30) DEFAULT NULL,
  `loginstat` tinyint(4) DEFAULT '0',
  `isAdmin` tinyint(4) DEFAULT '0',
  `MallAccess` text,
  `isActive` tinyint(4) DEFAULT '1',
  `hierarchycode` varchar(20) DEFAULT '',
  `ProcessOwner` varchar(20) DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `IDX_firstname` (`firstname`(20)),
  KEY `IDX_groupaccess` (`groupaccess`(10)),
  KEY `IDX_lastname` (`lastname`(20)),
  KEY `IDX_middlename` (`middlename`(20)),
  KEY `IDX_Userid` (`userid`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;


-- Table: tblxreadinglogs
CREATE TABLE `tblxreadinglogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `XLogID` varchar(20) DEFAULT NULL,
  `xsystemdate` datetime DEFAULT NULL,
  `xcomputerdate` datetime DEFAULT NULL,
  `xuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: tblzreadinglogs
CREATE TABLE `tblzreadinglogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ZLogID` varchar(20) DEFAULT NULL,
  `zsystemdate` datetime DEFAULT NULL,
  `zcomputerdate` datetime DEFAULT NULL,
  `zuser` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: trans_leads
CREATE TABLE `trans_leads` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `leadsID` varchar(100) DEFAULT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `middleName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `mobile_number` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `x_status` smallint(11) DEFAULT NULL,
  `progress_bar` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


-- Table: ttblref_refcitymun
CREATE TABLE `ttblref_refcitymun` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `psgcCode` varchar(255) DEFAULT NULL,
  `citymunDesc` text,
  `regDesc` varchar(255) DEFAULT NULL,
  `provCode` varchar(255) DEFAULT NULL,
  `citymunCode` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citymunDesc` (`citymunDesc`(10))
) ENGINE=MyISAM AUTO_INCREMENT=1648 DEFAULT CHARSET=utf8;

