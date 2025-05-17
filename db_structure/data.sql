--
-- PostgreSQL database dump
--

-- Dumped from database version 9.6.11
-- Dumped by pg_dump version 9.6.11

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: focus; Type: TABLE DATA; Schema: website; Owner: postgres
--

INSERT INTO website.focus VALUES ('Equality', NULL, 0, 127);
INSERT INTO website.focus VALUES ('Age Care', NULL, 2, 128);
INSERT INTO website.focus VALUES ('Agriculture', NULL, 2, 129);
INSERT INTO website.focus VALUES ('Child Education', 25, 2, 130);
INSERT INTO website.focus VALUES ('Cities/urban Developement', NULL, 2, 131);
INSERT INTO website.focus VALUES ('Community Development', NULL, 2, 132);
INSERT INTO website.focus VALUES ('Culture & Heritage', NULL, 2, 133);
INSERT INTO website.focus VALUES ('Disability', NULL, 2, 134);
INSERT INTO website.focus VALUES ('Disaster Management', NULL, 2, 135);
INSERT INTO website.focus VALUES ('Enviormental Issues', NULL, 2, 136);
INSERT INTO website.focus VALUES ('Hiv/aids', 22, 2, 137);
INSERT INTO website.focus VALUES ('Rural Development', NULL, 2, 138);
INSERT INTO website.focus VALUES ('Poverty Removal', NULL, 2, 139);
INSERT INTO website.focus VALUES ('Population', NULL, 2, 140);
INSERT INTO website.focus VALUES ('Housing & Slums', NULL, 2, 141);
INSERT INTO website.focus VALUES ('Cancer', 22, 2, 142);
INSERT INTO website.focus VALUES ('Science & Technology Development', NULL, 2, 143);
INSERT INTO website.focus VALUES ('Tribal People', NULL, 2, 144);
INSERT INTO website.focus VALUES ('Waste Management', 136, 2, 145);
INSERT INTO website.focus VALUES ('Pollution', 136, 2, 146);
INSERT INTO website.focus VALUES ('Drinking Water', 136, 2, 147);
INSERT INTO website.focus VALUES ('Health', NULL, 2, 22);
INSERT INTO website.focus VALUES ('Education', NULL, 2, 23);
INSERT INTO website.focus VALUES ('Art & Culture', NULL, 2, 24);
INSERT INTO website.focus VALUES ('Children Welfare', NULL, 2, 25);
INSERT INTO website.focus VALUES ('Women Empowerment', NULL, 2, 26);
INSERT INTO website.focus VALUES ('International', NULL, 2, 27);
INSERT INTO website.focus VALUES ('Income Tax', 37, 5, 71);
INSERT INTO website.focus VALUES ('Good and service Tax (GST)', 37, 5, 66);
INSERT INTO website.focus VALUES ('Excise Tax', 37, 5, 148);
INSERT INTO website.focus VALUES ('Corporate', NULL, 3, 2);
INSERT INTO website.focus VALUES ('Criminal', NULL, 3, 4);
INSERT INTO website.focus VALUES ('Service Tax', 37, 5, 150);
INSERT INTO website.focus VALUES ('Bankruptcy', NULL, 3, 6);
INSERT INTO website.focus VALUES ('Traffic', NULL, 3, 7);
INSERT INTO website.focus VALUES ('Registrar Of Company (roc) Compliance', NULL, 5, 151);
INSERT INTO website.focus VALUES ('Environmental', NULL, 3, 9);
INSERT INTO website.focus VALUES ('Intellectual Property', NULL, 3, 14);
INSERT INTO website.focus VALUES ('Emplyoment & Labour', NULL, 3, 15);
INSERT INTO website.focus VALUES ('Landloard & Tenant', NULL, 3, 20);
INSERT INTO website.focus VALUES ('Adoption', 5, 3, 10);
INSERT INTO website.focus VALUES ('Child Custody', 5, 3, 11);
INSERT INTO website.focus VALUES ('Divorce', 5, 3, 12);
INSERT INTO website.focus VALUES ('DIC Registration', NULL, 5, 65);
INSERT INTO website.focus VALUES ('Psychologists', NULL, 4, 16);
INSERT INTO website.focus VALUES ('Physicians', NULL, 4, 17);
INSERT INTO website.focus VALUES ('Dentist', NULL, 4, 18);
INSERT INTO website.focus VALUES ('Surgeon', NULL, 4, 19);
INSERT INTO website.focus VALUES ('Registration of Firms', NULL, 5, 69);
INSERT INTO website.focus VALUES ('Animal', NULL, 2, 21);
INSERT INTO website.focus VALUES ('Family', NULL, 3, 5);
INSERT INTO website.focus VALUES ('Public Interest', NULL, 3, 8);
INSERT INTO website.focus VALUES ('General Practice', NULL, 3, 1);
INSERT INTO website.focus VALUES ('Civil', NULL, 3, 3);
INSERT INTO website.focus VALUES ('Audit', NULL, 5, 28);
INSERT INTO website.focus VALUES ('Insolvency Code', NULL, 5, 67);
INSERT INTO website.focus VALUES ('Stock Exchange', NULL, 5, 83);
INSERT INTO website.focus VALUES ('Corporate Law Consultancy', NULL, 5, 87);
INSERT INTO website.focus VALUES ('Value-added Tax (vat)', 37, 5, 152);
INSERT INTO website.focus VALUES ('Share Valuation', 73, 5, 156);
INSERT INTO website.focus VALUES ('Taxation', NULL, 5, 37);
INSERT INTO website.focus VALUES ('Commodity Exchange', NULL, 5, 157);
INSERT INTO website.focus VALUES ('Criminal', 16, 4, 39);
INSERT INTO website.focus VALUES ('Technology', NULL, 0, 40);
INSERT INTO website.focus VALUES ('Bombay Stock Exchange (bse)', 83, 5, 158);
INSERT INTO website.focus VALUES ('Neurologist', NULL, 4, 42);
INSERT INTO website.focus VALUES ('Podiatrist', NULL, 4, 43);
INSERT INTO website.focus VALUES ('Urologist', NULL, 4, 44);
INSERT INTO website.focus VALUES ('Opthalmologist', NULL, 4, 45);
INSERT INTO website.focus VALUES ('Goodwill Mergers & Acquisitions', 70, 5, 155);
INSERT INTO website.focus VALUES ('Acupuncturist', 46, 4, 47);
INSERT INTO website.focus VALUES ('Physiotherapist', 46, 4, 48);
INSERT INTO website.focus VALUES ('Speech Therapist', 46, 4, 50);
INSERT INTO website.focus VALUES ('Dietitian/nutritionist', 46, 4, 51);
INSERT INTO website.focus VALUES ('Dermalogist', NULL, 4, 52);
INSERT INTO website.focus VALUES ('Cardiologist', NULL, 4, 53);
INSERT INTO website.focus VALUES ('Gastroenterologist', NULL, 4, 54);
INSERT INTO website.focus VALUES ('Ear-nose-throat (ent)', NULL, 4, 55);
INSERT INTO website.focus VALUES ('Gynecologist/obstetrician', NULL, 4, 56);
INSERT INTO website.focus VALUES ('Non-corporate Mergers & Acquisitions', 70, 5, 154);
INSERT INTO website.focus VALUES ('Orthopaedics', NULL, 4, 62);
INSERT INTO website.focus VALUES ('Civil', NULL, 2, 63);
INSERT INTO website.focus VALUES ('Accounting Services', NULL, 5, 64);
INSERT INTO website.focus VALUES ('Goverment Registrations', NULL, 5, 68);
INSERT INTO website.focus VALUES ('Mergers & Acquistions', NULL, 5, 70);
INSERT INTO website.focus VALUES ('Finance', NULL, 5, 72);
INSERT INTO website.focus VALUES ('Valuation', NULL, 5, 73);
INSERT INTO website.focus VALUES ('Financial Reporting', 72, 5, 74);
INSERT INTO website.focus VALUES ('Corporate Finance', 72, 5, 75);
INSERT INTO website.focus VALUES ('Financial Modelling', 72, 5, 76);
INSERT INTO website.focus VALUES ('Equity Research', NULL, 5, 77);
INSERT INTO website.focus VALUES ('Fund Management', NULL, 5, 78);
INSERT INTO website.focus VALUES ('Credit Analysis', NULL, 5, 79);
INSERT INTO website.focus VALUES ('Capital Markets', NULL, 5, 80);
INSERT INTO website.focus VALUES ('Arbitration', NULL, 5, 81);
INSERT INTO website.focus VALUES ('Risk Management', NULL, 5, 82);
INSERT INTO website.focus VALUES ('Strategic/management Consultancy', NULL, 5, 84);
INSERT INTO website.focus VALUES ('Management Accounting', NULL, 5, 85);
INSERT INTO website.focus VALUES ('Information Systems Audit', NULL, 5, 86);
INSERT INTO website.focus VALUES ('Abdominal', NULL, 4, 88);
INSERT INTO website.focus VALUES ('Abdominal Radiologist', 88, 4, 89);
INSERT INTO website.focus VALUES ('Abdominal Surgeon', 88, 4, 90);
INSERT INTO website.focus VALUES ('Addiction Physician', 17, 4, 92);
INSERT INTO website.focus VALUES ('Addiction Psychiatrist', 16, 4, 93);
INSERT INTO website.focus VALUES ('Audiologist', NULL, 4, 49);
INSERT INTO website.focus VALUES ('Non-Conventional', NULL, 4, 46);
INSERT INTO website.focus VALUES ('Allergist', NULL, 4, 94);
INSERT INTO website.focus VALUES ('Anatomic & Clinical Pathologist', NULL, 4, 95);
INSERT INTO website.focus VALUES ('Anesthesiologist', 46, 4, 96);
INSERT INTO website.focus VALUES ('Asthma', NULL, 4, 97);
INSERT INTO website.focus VALUES ('Bariatrician', 46, 4, 98);
INSERT INTO website.focus VALUES ('Cardiothoracic', 19, 4, 99);
INSERT INTO website.focus VALUES ('Child & Adolescent Psychiatrist', 16, 4, 100);
INSERT INTO website.focus VALUES ('Chiropractor', 46, 4, 101);
INSERT INTO website.focus VALUES ('Clinical Neurophysiologist', 42, 4, 102);
INSERT INTO website.focus VALUES ('Colorectal', 19, 4, 103);
INSERT INTO website.focus VALUES ('Diabetologist', NULL, 4, 104);
INSERT INTO website.focus VALUES ('Pediatrician', NULL, 4, 105);
INSERT INTO website.focus VALUES ('Dermalogic Surgeon', 19, 4, 106);
INSERT INTO website.focus VALUES ('Critical Care', NULL, 4, 107);
INSERT INTO website.focus VALUES ('Cosmetic', 19, 4, 108);
INSERT INTO website.focus VALUES ('Anesthesiologist - Critical Care', 107, 4, 109);
INSERT INTO website.focus VALUES ('Pediatrician - Critical Care', 107, 4, 110);
INSERT INTO website.focus VALUES ('Physician - Critical Care', 107, 4, 111);
INSERT INTO website.focus VALUES ('Surgeon - Critical Care', 107, 4, 112);
INSERT INTO website.focus VALUES ('Radiologist', NULL, 4, 113);
INSERT INTO website.focus VALUES ('Endocrinologist', NULL, 4, 114);
INSERT INTO website.focus VALUES ('Endodontic', NULL, 4, 115);
INSERT INTO website.focus VALUES ('Epileptologist', NULL, 4, 116);
INSERT INTO website.focus VALUES ('Plastic Surgeon', 19, 4, 117);
INSERT INTO website.focus VALUES ('General Practitioner', NULL, 4, 118);
INSERT INTO website.focus VALUES ('Immunologist', NULL, 4, 124);
INSERT INTO website.focus VALUES ('Oral Surgeon', 19, 4, 125);
INSERT INTO website.focus VALUES ('Spinal Cord Injury', NULL, 4, 126);
INSERT INTO website.focus VALUES ('National Stock Exchange (nse)', 83, 5, 159);
INSERT INTO website.focus VALUES ('Business Valuation', 73, 5, 160);
INSERT INTO website.focus VALUES ('Property Valuation', 73, 5, 161);
INSERT INTO website.focus VALUES ('Project Report', 72, 5, 162);
INSERT INTO website.focus VALUES ('Credit Monitoring Arrangement (cma) Data', 72, 5, 163);
INSERT INTO website.focus VALUES ('Customs Tax', 37, 5, 149);
INSERT INTO website.focus VALUES ('Corporate Mergers & Acquisitions', 70, 5, 153);


--
-- Data for Name: professional; Type: TABLE DATA; Schema: website; Owner: postgres
--

INSERT INTO website.professional VALUES (7, 'tanya', '$2y$10$UCPlyuZPvc6QI3JTp0NNzOsYeJSLnIDQG7ELJCrCSYXJvpYBFV9UO', 'tanya@mail.com', NULL, NULL, true, 3, '2018-06-21 19:48:16.438164+05:30', 'eabdd77d-044e-4c9b-fce9-cbdb3bc8c2c7', 2, true, 0, 'Tanya', 'images/profile/female_lawyer.jpg', '2018-06-06', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Khurd, LLB&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Khurd, LLM&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Khurd, Uttar Pradesh 247001, India', 1, '{2,3,4,5}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '', NULL, '{English,Bangla}', NULL, '{"High Court"}', NULL, '{}', true, NULL);
INSERT INTO website.professional VALUES (25, 'rohit', '$2y$10$ofWmuA4Vst6Svu3oxz9li.uGAtY9l3KgvdQGE/Wc2ERNOnxr3H6MK', 'rohit@examplemail.com', NULL, NULL, true, 5, '2018-06-21 20:39:26.817923+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Rohit', 'images/profile/male_ca.jpg', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each client needs to be treated differently, when you come to me you are guarnteed&amp;nbsp; confidentiality and support for any problem you might have.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, '2 Ntw-A, Rajasthan 125101, India', 28, '{64,65}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '24', NULL, '{English,Hindi}', NULL, NULL, NULL, '{}', true, NULL);
INSERT INTO website.professional VALUES (29, 'rakhi', '$2y$10$Yn731kND0Vz30D23jaiTGek6fQQh.GEg9CYOew4.WBh0k/3UWni.a', 'rakhi@mailexample.c', NULL, NULL, true, 2, '2018-06-21 20:55:44.480367+05:30', '50eddd0e-3ffd-f7f5-1753-aedb7f184923', 2, true, 0, 'Rakhi', 'images/profile/ngo.jpg', '2018-06-21', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;p&gt;We have recieved several Certicates from UNESCO.&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;We specialise in animal protection, educating children and adults and preserving art and culture.&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, '8 Stb, Rajasthan 335803, India', 21, '{23,24}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '28', NULL, '{English,Hindi}', NULL, '{"State Wide"}', NULL, '{}', true, NULL);
INSERT INTO website.professional VALUES (9, 'johnny', '$2y$10$bpYPgcuN.Lg.uRC.SGj6xeOnLHLPR3GOAXmlX7q5yBbkJpAGbouym', 'john@examplemail.com', NULL, NULL, true, 3, '2018-06-21 19:58:32.101006+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'John Law Firm', 'images/profile/male_lawyer.jpg', '2018-06-21', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;Delhi University, LLB&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;Munsari, LLB&lt;/p&gt;
&lt;p&gt;I represent clients in criminal and civil litigation and other legal proceedings, draw up legal documents, or manage or advise clients on legal transactions. &lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, '30 Rwd, Rajasthan 335523, India', 1, '{3,4,9,14}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English}', true, '{"High Court"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (11, 'benjohn', '$2y$10$OSXdjwbH.DxvKauk1mAnju8uZg2saeO75H1qaJClgHlWQ3QQ/VE2e', 'ben@examplemail.com', NULL, NULL, true, 3, '2018-06-21 20:01:21.725246+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Ben Johnson', 'images/profile/male_lawyer.jpg', '2018-06-21', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;Delhi University, LLB&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;Munsari, LLB&lt;/p&gt;
&lt;p&gt;I represent clients in criminal and civil litigation and other legal proceedings, draw up legal documents, or manage or advise clients on legal transactions. &lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Adampur Mandi, Haryana, India', 6, '{11,6,7}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English}', true, '{"High Court"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (10, 'laura', '$2y$10$9SHlvIyiiqc0ugdu06HeBuY7/m1jZhWzgj6I1GWvtPMx376Uak3IO', 'laura@examplemail.com', NULL, NULL, true, 3, '2018-06-21 19:59:38.650883+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Laura Law Firm', 'images/profile/female_lawyer.jpg', '2018-06-21', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;Delhi University, LLB&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;Munsari, LLB&lt;/p&gt;
&lt;p&gt;I represent clients in criminal and civil litigation and other legal proceedings, draw up legal documents, or manage or advise clients on legal transactions. &lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, '24 Rwd-A, Rajasthan 335523, India', 1, '{3,4,9,14}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English}', true, '{"High Court"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (27, 'landhand', '$2y$10$vldTCx7s8cQaGNOW2Hx7CeF1sQrrRHXQQ58.nfroT0X1sKNT2Chtq', 'lah@examplemail.com', NULL, NULL, true, 2, '2018-06-21 20:42:05.636389+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Lend a Hand', 'images/profile/ngo.jpg', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each client needs to be treated differently, when you come to me you are guarnteed&amp;nbsp; confidentiality and support for any problem you might have.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Punjab 148031, India', 21, '{22,137,142,23}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English,Hindi}', true, '{"State Wide"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (28, 'animalprot', '$2y$10$6yL53bpd4/Ap5l/2W4hHu.wpvCt1hr4443XsPXUmX5YLmXJJRQQwW', 'animalprot@mailexample.c', NULL, NULL, true, 2, '2018-06-21 20:54:09.234145+05:30', '50eddd0e-3ffd-f7f5-1753-aedb7f184923', 2, true, 0, 'Animal Protection', 'images/profile/ngo1.jpg', '2018-06-21', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;p&gt;We have recieved several Certicates from UNESCO.&lt;/p&gt;
&lt;p&gt;&nbsp;&lt;/p&gt;
&lt;p&gt;We specialise in animal protection, educating children and adults and preserving art and culture.&lt;/p&gt;
&lt;p&gt;&nbsp;&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, '8 Stb, Rajasthan 335803, India', 21, '{23,24}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English,Hindi}', NULL, '{"State Wide"}', NULL, '{}', true, NULL);
INSERT INTO website.professional VALUES (8, 'rahul', '$2y$10$GXTAFVcdPMiQFSs16h5Cn.iycn9mBEeRHUIzGX5n0PuxuxKg0qO2C', 'rahul@examplemail.com', NULL, NULL, true, 3, '2018-06-21 19:56:47.462511+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Rahul Law Firm', 'images/profile/male_lawyer.jpg', '2018-06-21', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;Delhi University, LLB&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;Munsari, LLB&lt;/p&gt;
&lt;p&gt;I represent clients in criminal and civil litigation and other legal proceedings, draw up legal documents, or manage or advise clients on legal transactions. &lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Munsari, Rajasthan 335523, India', 1, '{3,4,9,14}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English}', true, '{"High Court"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (16, 'raj20', '$2y$10$MhEPMeGtkFUE5hTuuOMFJefdJm7RZSdnKsyeUR.OuyT8qO.oj52Ye', 'raj@examplemail.com', NULL, NULL, true, 4, '2018-06-21 20:17:39.954497+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Raj', 'images/profile/male_doc.png', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each patient needs to be treated differently, when you come to me you are guarnteed 100% confidentiality and support for any problem you might have.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Chautala, Haryana 125101, India', 118, '{17}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '', NULL, '{English,Hindi}', NULL, '{Hospital,"Home Visits"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (12, 'benjo', '$2y$10$V3w8/67P8B2AkvVXjISVVuT/3cLcLn0G37JTKuNGWYu6Lvp93FOJu', 'benj@examplemail.com', NULL, NULL, true, 4, '2018-06-21 20:07:28.575548+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Ben Johnson', 'images/profile/male_doc.png', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;Delhi University, LLB&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;Munsari, LLB&lt;/p&gt;
&lt;p&gt;I represent clients in criminal and civil litigation and other legal proceedings, draw up legal documents, or manage or advise clients on legal transactions. &lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Adampur Mandi, Haryana, India', 16, '{93,39,100}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '', NULL, '{English}', true, '{Clinic,"Home Visits"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (15, 'wilson', '$2y$10$6N9yfASZwCIx1QPEc9IGxeeQnXHyDk.NMGiwLCheeu9LW6HjpRY4S', 'wilson@examplemail.com', NULL, NULL, true, 4, '2018-06-21 20:16:10.047498+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Wilson', 'images/profile/male_doc.png', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each patient needs to be treated differently, when you come to me you are guarnteed 100% confidentiality and support for any problem you might have.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Chautala, Haryana 125101, India', 118, '{17}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '', NULL, '{English,Hindi}', NULL, '{Hospital,"Home Visits"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (14, 'doryw', '$2y$10$Y/KL/LOxletAlqfE37GkPu49LB28xOs1TbayhJHsIh2EJnWsSAQeG', 'dory@examplemail.com', NULL, NULL, true, 4, '2018-06-21 20:14:48.830909+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Dory wilkinson', 'images/profile/female_doc.jpg', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;We have 10 dentists in our clinic, each specialising in there area of expertise. We care about hygine and have least amount of waiting time.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Chautala, Haryana 125101, India', 108, '{108}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English,Hindi}', NULL, '{Clinic,"Home Visits"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (13, 'sangaria', '$2y$10$Vb.Wb4NqZO75.EuL8QTzxO.PvlV3jz3nW0OHFC7kKjxgKreDwIrP.', 'sang@examplemail.com', NULL, NULL, true, 4, '2018-06-21 20:12:45.56649+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Sangaria Dentists', 'images/profile/female_doc.jpg', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Masoorie&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of London&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each patient needs to be treated differently, when you come to me you are guarnteed 100% confidentiality and support for any problem you might have.&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Sangaria, Rajasthan, India', 16, '{18}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English}', NULL, '{Clinic,"Home Visits"}', true, '{}', true, NULL);
INSERT INTO website.professional VALUES (24, 'mishra', '$2y$10$y5JihS28Zq1yMYNBEplQI.0H5HJN/ZXBCd8.0DwSal7Ro6ufSXGge', 'mishra@examplemail.com', NULL, NULL, true, 5, '2018-06-21 20:29:34.50906+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Mishra CA Firm', 'images/profile/male_ca.jpg', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each client needs to be treated differently, when you come to me you are guarnteed&amp;nbsp; confidentiality and support for any problem you might have.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Sukheranwala, Haryana, India', 28, '{65,67}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '0', NULL, '{English,Hindi}', NULL, NULL, NULL, '{}', true, NULL);
INSERT INTO website.professional VALUES (26, 'deepika', '$2y$10$JZJzd9Gj0N.e9ultu8p1l.f6l7cJDS5EeKALVyG5ymQe.bwceBLcy', 'deepika@examplemail.com', NULL, NULL, true, 5, '2018-06-21 20:40:42.157673+05:30', 'f7feac99-20b9-9a19-8985-4750bd34ca16', 2, true, 0, 'Deepika', 'images/profile/female_ca.jpg', '2013-02-05', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of Delhi&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of Sangaria&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;Each person is different, and that why each client needs to be treated differently, when you come to me you are guarnteed&amp;nbsp; confidentiality and support for any problem you might have.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Punjab 151502, India', 28, '{64,65}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '24', NULL, '{English,Hindi}', NULL, NULL, NULL, '{}', true, NULL);
INSERT INTO website.professional VALUES (30, 'lenad', '$2y$10$nuUTAj3vWxtwOxVp1iUOTe6IIUoshMZ1py3vV8PGy7PpldjHmq6aq', 'lena@email.com', NULL, NULL, false, 5, '2018-06-22 13:06:56.483015+05:30', '89c55907-1ed8-3904-b0db-c33c295cc041', 2, true, 0, 'Lena David', 'images/profile/female_ca.jpg', '2018-06-22', '&lt;h1 class=&quot;mceNonEditable&quot;&gt;&lt;strong&gt;Qualifications&lt;/strong&gt;&lt;/h1&gt;
&lt;h2&gt;Post-graduation&lt;/h2&gt;
&lt;p&gt;University of London&lt;/p&gt;
&lt;h2&gt;Graduation&lt;/h2&gt;
&lt;p&gt;University of New York&lt;/p&gt;
&lt;p&gt;&amp;nbsp;&lt;/p&gt;
&lt;p&gt;I have 10 years experience , and have been working with Mishra CA Firm for 2.5 years.&amp;nbsp; I provide audit and other services for startups to big organisation.&lt;/p&gt;', NULL, NULL, NULL, NULL, NULL, 'Muzaffarpur Khunti, Uttar Pradesh 250406, India', 28, '{73,77,78,79,80,81,82,83,84}', '{09:00:00,17:00:00}', '{13:00:00,14:00:00}', '24', NULL, '{English,Hindi}', true, '{Local,State,National}', true, '{}', false, NULL);


--
-- Data for Name: appointment; Type: TABLE DATA; Schema: website; Owner: postgres
--



--
-- Name: appointmentSetting_settingId_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website."appointmentSetting_settingId_seq"', 3, true);


--
-- Name: appointment_appointmentId_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website."appointment_appointmentId_seq"', 1, true);


--
-- Data for Name: appointmentsetting; Type: TABLE DATA; Schema: website; Owner: postgres
--

INSERT INTO website.appointmentsetting VALUES (3, 30, '{4,0}', 0.5, 1000, NULL, NULL, 7);
INSERT INTO website.appointmentsetting VALUES (4, 30, '{0}', 0.5, 2000, NULL, NULL, 8);
INSERT INTO website.appointmentsetting VALUES (5, 30, '{0}', 0.5, 2000, NULL, NULL, 9);
INSERT INTO website.appointmentsetting VALUES (6, 30, '{0}', 0.5, 2000, NULL, NULL, 10);
INSERT INTO website.appointmentsetting VALUES (7, 35, '{0}', 0.5, 2000, NULL, NULL, 11);
INSERT INTO website.appointmentsetting VALUES (8, 35, '{0}', 0.5, 1000, NULL, NULL, 12);
INSERT INTO website.appointmentsetting VALUES (9, 10, '{0}', 0.5, 1000, NULL, NULL, 13);
INSERT INTO website.appointmentsetting VALUES (10, 20, '{0}', 0.5, 1000, NULL, NULL, 14);
INSERT INTO website.appointmentsetting VALUES (11, 25, '{0}', 0.5, 1000, NULL, NULL, 15);
INSERT INTO website.appointmentsetting VALUES (12, 15, '{0}', 0.5, 500, NULL, NULL, 16);
INSERT INTO website.appointmentsetting VALUES (20, 30, '{0}', 0.5, 550, NULL, NULL, 24);
INSERT INTO website.appointmentsetting VALUES (21, 30, '{0}', 0.5, 550, NULL, NULL, 25);
INSERT INTO website.appointmentsetting VALUES (22, 30, '{0}', 0.5, 700, NULL, NULL, 26);
INSERT INTO website.appointmentsetting VALUES (23, 30, '{0}', 0.5, 700, NULL, NULL, 27);
INSERT INTO website.appointmentsetting VALUES (24, NULL, '{0}', 0.5, NULL, NULL, NULL, 28);
INSERT INTO website.appointmentsetting VALUES (25, NULL, '{0}', 0.5, NULL, NULL, NULL, 29);
INSERT INTO website.appointmentsetting VALUES (26, NULL, '{0}', 0.5, 4000, NULL, NULL, 30);


--
-- Data for Name: article; Type: TABLE DATA; Schema: website; Owner: postgres
--

INSERT INTO website.article VALUES (2, 1, '{"name": "admin", "tags": ["women empowerment,2"], "about": "", "story": "&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In a &lt;em&gt;fight&lt;/em&gt; between &lt;em&gt;countries, religion and castes&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In an &lt;em&gt;altercation&lt;/em&gt; over auto &lt;em&gt;fair&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In &lt;em&gt;shortage&lt;/em&gt; of a &lt;em&gt;loo&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In the &lt;em&gt;humiliation&lt;/em&gt; of &lt;em&gt;political&lt;/em&gt; party,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In the &lt;em&gt;insecurities&lt;/em&gt; of a &lt;em&gt;poor&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In the &lt;em&gt;boasting&lt;/em&gt; of a &lt;em&gt;brat&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In the &lt;em&gt;ditches&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In the &lt;em&gt;riches&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;&lt;span class=&quot;bold italic&quot;&gt;In the &lt;em&gt;darkness&lt;/em&gt;,&lt;/span&gt;&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In broad &lt;em&gt;daylight&lt;/em&gt;.&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In a &lt;em&gt;dispute&lt;/em&gt; over land,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In a &lt;em&gt;saaree&lt;/em&gt; or a &lt;em&gt;burka&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;In a &lt;em&gt;jeans&lt;/em&gt; or a &lt;em&gt;skirt&lt;/em&gt;,&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;&lt;strong&gt;&lt;em&gt;In this moment&lt;/em&gt;,&lt;/strong&gt;&lt;/p&gt;\r\n&lt;p class=&quot;center&quot; lang=&quot;zxx&quot; style=&quot;margin-bottom: 0cm; text-align: center;&quot;&gt;&lt;strong&gt;A GIRL IS GETTING RAPED SOMEWHERE.&lt;/strong&gt;&lt;/p&gt;", "title": "Everyone &amp; Everywhere", "filepath": "images/article/article_2.png", "createdat": "2018-05-19 00:02:24", "modifiedat": "2018-05-19 12:51:07"}');
INSERT INTO website.article VALUES (1, 1, '{"name": "admin", "tags": ["civil,2", "women empowerment,2"], "about": "", "story": "&lt;table class=&quot;textalignjustify&quot; style=&quot;width: 100%; border-collapse: collapse; border-style: hidden;&quot; border=&quot;1&quot;&gt;\r\n&lt;tbody&gt;\r\n&lt;tr&gt;\r\n&lt;td style=&quot;width: 39.1851%; vertical-align: top;&quot;&gt;\r\n&lt;h2&gt;&lt;em&gt;&lt;strong class=&quot;textalignleft&quot;&gt;Forms and Guardianship&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;\r\n&lt;p style=&quot;padding-left: 30px;&quot;&gt;Lets start with a seemingly &amp;lsquo;minor discrimination&amp;rsquo; - Forms. Yes, forms. As you may have noticed, most form ask if you are son of, daughter of or wife of someone. And that someone has to be a male. There is no - &amp;lsquo;are you husband of someone&amp;rsquo;. NO! It&amp;rsquo;s always &lt;em&gt;wife of&lt;/em&gt;. Although it may have been for documentation purposes, when &amp;ldquo;house-wives&amp;rdquo; did not have any other existential proof. However, now everyone has identification such as aadhar cards, voting id, bank accounts, this method is no longer needed. There are marriage licence for census purpose and if still the government for some reason thinks its necessary, why not do it as &amp;ldquo;husband of&amp;rdquo; as well? &lt;em&gt;This kind of discrimination may seem minor but it just shows the general thinking of the society and the government.&lt;/em&gt; Women should not be seen as daughter of or wife of someone but as an individual. The repercussions of this is not only limited to the humiliation of filling these forms, but also reflects on not only the way society thinks but also, how government makes laws and policies. For example, a father is considered the &amp;lsquo;natural guardian&amp;rsquo; of a child, even though in majority cases the custody of a child is given to a mother, because I guess she is the &amp;lsquo;natural parent&amp;rsquo;? &lt;strong&gt;The women, however, is not considered &amp;ldquo;equal guardian&amp;rdquo; of the child&lt;/strong&gt;! So, a field in the form is not just that, it is much more, it is a representative of every way in which the government thinks of women as lesser than males.&lt;/p&gt;\r\n&lt;h2 class=&quot;left&quot;&gt;&lt;em&gt;&lt;strong class=&quot;textalignleft&quot;&gt;Personal Religious Laws&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;\r\n&lt;p style=&quot;padding-left: 30px;&quot;&gt;In idea, we have the right to equality, we have unity in diversity but in law we only have diversity. Every religion, has it&amp;rsquo;s own personal law and each of them is discriminatory to women in their own ways. Recently, equality took a huge victory with the abolishment of triple talak, but there is still a long way to go.&amp;nbsp;&lt;/p&gt;\r\n&lt;/td&gt;\r\n&lt;td style=&quot;width: 6.69021%;&quot;&gt;&amp;nbsp;&lt;/td&gt;\r\n&lt;td style=&quot;width: 54.1248%; vertical-align: top;&quot;&gt;\r\n&lt;figure class=&quot;image align-right&quot;&gt;&lt;img style=&quot;width: 656px; height: 1640px;&quot; title=&quot;5 ways goverment screws women progress&quot; src=&quot;../../../images/article/5_ways_goverment_screws_women_progress.png&quot; alt=&quot;&quot; width=&quot;800&quot; height=&quot;2000&quot; /&gt;\r\n&lt;figcaption&gt;5 Ways Goverment Sabotages Women''s Progress&lt;/figcaption&gt;\r\n&lt;/figure&gt;\r\n&lt;/td&gt;\r\n&lt;/tr&gt;\r\n&lt;/tbody&gt;\r\n&lt;/table&gt;\r\n&lt;p class=&quot;textalignjustify&quot;&gt;For example, in Hindu inheritance law, a if a women dies and have no husband and children, her property goes to the parents of her husband and not her own parents, in absence of a will. This is applicable even if she was ill treated by her in laws. Contrary to this, women has no right on husbands assets in case of a divorce, so basically, even after years of marriage, a divorced women can be potentially homeless. Similarly, according to Parsi law, a non-Parsi wife or widow cannot inherit. Children of a non-Parsi wife and Parsi husband have the right to the property, however, children of Parsi wife and non-Parsi man have no right to the property. Polygamy (no polyandry by the way) is allowed for Hindus in Goa. Yes, &lt;em&gt;there is no bound to the discriminatory and non-secular policies and laws, in this secular and republic nation.&lt;/em&gt;&lt;/p&gt;\r\n&lt;h2 class=&quot;textalignjustify&quot;&gt;&lt;em&gt;&lt;strong&gt;Child marriage laws&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;\r\n&lt;p class=&quot;textalignjustify&quot; style=&quot;padding-left: 30px;&quot;&gt;Another gem of the government law, is illegality of child marriage, so &lt;strong&gt;to marry a child is wrong but &amp;ndash; ta-da &amp;ndash; to stay married to a child is NOT illegal&lt;/strong&gt;. So, unless, someone or the police does not intervene before the nuptials, there is nothing anyone can do about it. The disparity in the legal age of marriage &amp;ndash; 18 for women and 21 for men, itself shows the thinking behind law making. Older men should marry young women, isn&amp;rsquo;t it? So, a 18 year girl cannot marry her boyfriend if she wants, but a 8 year old can stay married to an 80 year old!&lt;/p&gt;\r\n&lt;h2 class=&quot;textalignjustify&quot;&gt;&lt;em&gt;&lt;strong&gt;Rape laws&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;\r\n&lt;p class=&quot;textalignjustify&quot; style=&quot;padding-left: 30px;&quot;&gt;Although the laws on rape has been made stringent since the Delhi Gang rape case, the follow through and other laws which render these laws useless, still have strong hold on the constitution of India. One of the examples, was demonstrated in the point above,&lt;strong&gt; the rape of a &amp;lsquo;married child&amp;rsquo; is not illegal, as the marriage is not illegal once this is done&lt;/strong&gt;. That shouldn&amp;rsquo;t matter right? &lt;em&gt;As rape is rape, how does it matter if someone is married or not? Turns out, it matters, marital rape is not recognised in India. Not only that, the &lt;strong&gt;rape of separated spouse carries less sentence&lt;/strong&gt;.&lt;/em&gt; This means, if a woman is &lt;a title=&quot;A poem on rape&quot; href=&quot;http://www.kniew.com/articles/title/2/Everyone_%2526_Everywhere&quot;&gt;raped&lt;/a&gt; repeatedly for several years in a forced marriage, and somehow finds the strength to file for divorce, and separate from her husband, who then again rapes her, not only the years of torture will not be counted, but also, the subsequent rape will carry less sentence. Where is the justice in that? Outrageous!&lt;/p&gt;\r\n&lt;h2 class=&quot;textalignjustify&quot;&gt;&lt;em&gt;&lt;strong&gt;Female Taxation&lt;/strong&gt;&lt;/em&gt;&lt;/h2&gt;\r\n&lt;p class=&quot;textalignjustify&quot; style=&quot;padding-left: 30px;&quot;&gt;Did you know that kumkum, bindi, sindur and semen, yes, semen is exempt from the GST but &lt;strong&gt;sanitary napkins have a tax of 12% whereas tampons have a tax of 18%&lt;/strong&gt;. So I guess every child needs the former but they don&amp;rsquo;t the latter. The former is basic necessity, as every female needs to be a traditional Hindu wife with kumkum and sindur, and in case her husbands is infertile, she can perform her &amp;lsquo;natural duties&amp;rsquo; of being a mother, by buying semen GST FREE! But, a girl has to stop going to school as soon as her period starts , (may be according to patriarchal thinking) to perform her &amp;lsquo;natural duty&amp;rsquo; as a mother, at the age of 10. Morever, in the GST council meeting,&lt;em&gt; taxes were reduced from 178 items, this included, a 13% reduction (from 18 to 5%) in Tamarind kernel powder and &amp;lsquo;mehendi paste in cones&amp;rsquo;, OFFCOURSE! But not women hygene products&lt;/em&gt;, which further highlights the mentality behind the law making in this country! Sanitary pads, are the basic necessity of living a civilised life, the overall cost of leading a human life should not be so high, and should not have tax applicable on it. Just imagine sitting in a room with your clothes soaked in blood for days, and you will realise how inhumane these laws are. #taxOnBeingWomen #taxDiscrimination&lt;/p&gt;\r\n&lt;p class=&quot;textalignjustify&quot; style=&quot;margin-bottom: 0cm;&quot;&gt;&lt;strong&gt;TLDR&lt;/strong&gt;: The government may not be actively seeking to sabotage the female population of India, but they have to realise that the laws are archaic and discriminatory, some of them have lost their meaning and some of them are just cruel! These laws and practices needs to be challenged and changed. &lt;strong&gt;These laws in combination with the wage gap for the same job, makes sure that women&amp;rsquo;s saving and hence her quality of life and chance to progress in the world is jeopardize.&lt;/strong&gt; While some politicians may give vague statements in the support of this equality, the truth of the matter is no action is been taken. The result of this is that even basic necessity such as sanitary napkins and right not to be raped are not available to young girls due to which many of them have to stop going to school and hence are systematically being made into &amp;lsquo;typical docile house wives&amp;rsquo;, with no prospects and no happiness&lt;strong&gt;. Every human being, male, female or others, should have the right to decide, right to prosper and be happy.&lt;/strong&gt; For that to happen, this outrageous systematic discrimination needs to stop and laws and policies needs to change, NOW!!&lt;/p&gt;\r\n&lt;p class=&quot;textalignjustify&quot; style=&quot;margin-bottom: 0cm;&quot;&gt;#equality #systematicAbuse #crimesAgainstWomen #lawDiscrimination #changeTheGovernance&lt;/p&gt;\r\n&lt;p&gt;&lt;code class=&quot;textalignjustify&quot;&gt;&lt;/code&gt;&lt;code class=&quot;textalignjustify&quot;&gt;&lt;/code&gt;&lt;/p&gt;", "title": "5 Ways Goverment Sabotages Women''s Progress [infographics]", "filepath": "images/article/article_1.png", "createdat": "2018-05-18 01:49:57", "modifiedat": "2018-05-19 13:55:58"}');
INSERT INTO website.article VALUES (3, 24, '{"name": "Anonymous", "tags": ["equality,0"], "about": "", "story": "&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want males to have unfair advantage,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want females to have unfair advantage,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t believe in patriarchal society,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t believe in matriarchal society,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to work, study and drive fast,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to ride a bike, without it amazing or stealing stares from everybody.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I neither want to watch sexist movies, nor do I want to laugh at gender biased jokes,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want to blend in the background of someone else''s life,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to change by name, my identity for someone else,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to go live in someone else&amp;rsquo;s house, I want a house of my own,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to depend on anyone for my daily bread and butter,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to be independent,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be a small part of someone&amp;rsquo;s life,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to have my own identity,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want to be &quot;Mrs.&quot; so and so,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want to work for HIS family business,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to have my own family business,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to ask someone whenever I want something,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to support and help my family for as long as I want,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be treated &amp;ldquo;like a son&amp;rdquo;, I just want to be your child,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want to marry,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to marry and work together,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to decide if and when to marry,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want us to be equal parts of each other&amp;rsquo;s life,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I believe marriage is an EQUAL PARTNERSHIP between husband and wife,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want him to be the sole reason of my existence,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to call my husband my god,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be saved by a humongous male deity,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t agree that to honor goddess I need to refer them as a male,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want you to raise me to a pedestal and pray to me,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want a mother&amp;rsquo;s day, a daughter&amp;rsquo;s day, a women&amp;rsquo;s day,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want you to be chivalrous,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want you to pay for me,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be your punching bag,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be a doormat,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to enjoy my life,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to decide if and when I want children,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want kids,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to work although I am a mother,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I think women are no &quot;baby producing machines&quot;,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want food-''the basic need of HUMANS'' not to be denied to anyone based on gender,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want to cook,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to eat, drink, sleep; whatever, whenever and wherever I want,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to wear whatever I want,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to care how short or how long my dress is,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I like my hair short,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to apply makeup and wear jewelry; or maybe I do,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to look all pretty and kempt,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to sit and walk however I want,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be stared at 24X7,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I believe inner beauty is more important than outer beauty,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want my fate to be decided when I am still a fetus,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t see women as mere beautiful sex objects,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I see women as intellectual human beings,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to roam freely on streets,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I object to children both male and female being molested by their relatives or otherwise,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want all the rapists to be hanged till death,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t believe it is rape victim&amp;rsquo;s fault,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I find it ridiculous when these offenders say &amp;ldquo;she was asking for it&amp;rdquo;,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;Oh oh oh, I can think,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;Am I breathing??&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;Then for sure,&amp;nbsp;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to express my views without the tag of feminist attached to it,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want this world to be better place to LIVE in,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I believe the all HUMANS have equal rights,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I find it insulting that I have to make people understand equality,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I find the notion that I have to fight for something which should have been my natural right,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I find the language very sexist,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don''t want dictionary to have a special word for equality between men and women,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I believe the term equality is enough,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I feel the term feminist is derogatory,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I feel feminist is the most sexist term to be coined,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to shout, cry, laugh, speak, dance, sing, jump, walk, run, swim, yawn, stretch, move, smile, frown, turn, bend, wake up, sleep, eat, drink, exercise, not exercise, have fun, study, work, do whatever the hell I want, without being judged, questioned or stopped,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be known just as a daughter, sister, wife or a mother, a women in a man&amp;rsquo;s life, or a women behind a man&amp;rsquo;s success, I want to be known for me,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be prisoner in a huge mansion, I don&amp;rsquo;t want to be a slave in a fancy house, I don&amp;rsquo;t want to follow instruction, I want to make my own decisions,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t care what others think, I don&amp;rsquo;t want to be blindfolded and be led by a man, I want to pave a way of my own,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to explore, I want to travel and not sit at home,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I don&amp;rsquo;t want to be suffocated in my own home,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I&amp;rsquo;m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want to be me and not others want me to be,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I want all the sexist notions that says otherwise to be abolished,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I just want to be another human being,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I''m a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I say, stop this madness now! Stop calling me a feminist, I am just a human who wants to breath, I don&amp;rsquo;t want riots, I don&amp;rsquo;t want protests, I just want you to respect me as a human being. Just call be my name and understand equality, don&amp;rsquo;t call me a radical, a maverick or a rebel, I am just another human being,&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I am a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;I say, I am NOT a feminist.&lt;/p&gt;\r\n&lt;p class=&quot;textaligncenter&quot;&gt;But they say, I''m a feminist!&lt;/p&gt;", "title": "I am not a FEMENIST!", "filepath": "images/article/d922f75113.png", "createdat": "2018-05-19 11:45:49", "modifiedat": "2018-05-19 12:45:00"}');


--
-- Name: article_articleid_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website.article_articleid_seq', 3, true);


--
-- Data for Name: articlecomment; Type: TABLE DATA; Schema: website; Owner: postgres
--



--
-- Data for Name: articlelike; Type: TABLE DATA; Schema: website; Owner: postgres
--



--
-- Name: articlelike_likeid_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website.articlelike_likeid_seq', 1, true);


--
-- Name: comment_commentid_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website.comment_commentid_seq', 1, true);


--
-- Name: professionalfocus_professionalfocusid_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website.professionalfocus_professionalfocusid_seq', 163, true);


--
-- Data for Name: professionalrating; Type: TABLE DATA; Schema: website; Owner: postgres
--

INSERT INTO website.professionalrating VALUES (1, 27, 29, 3, 'They are the best', '2018-06-21 21:04:59.335+05:30', NULL);
INSERT INTO website.professionalrating VALUES (3, 28, 29, 5, 'I have worked here for 2 years, and through them have helped a lot of animals, they are the best at what they do.', '2018-06-21 22:33:59.789+05:30', NULL);
INSERT INTO website.professionalrating VALUES (4, 15, 29, 4, 'Very perceptive and good with diagnosis', '2018-06-21 22:35:45.334616+05:30', '1970-01-01 11:00:00+05:30');
INSERT INTO website.professionalrating VALUES (5, 9, 29, 3, 'I went to Johnny to protect my new product, by applying for a patent, not only did he made the process very simple and effortless for me but also got it done quickly.', '2018-06-21 22:52:16.544083+05:30', '1970-01-01 11:00:00+05:30');
INSERT INTO website.professionalrating VALUES (6, 24, 29, 5, 'I am starting a new NGO, and have very little knowledge of how to do things. Mishra CA firms was very helpful and have great employees, specially deepika who helped me a lot and was very patient with me.', '2018-06-21 23:09:07.45+05:30', NULL);


--
-- Name: professionalrating_rateid_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website.professionalrating_rateid_seq', 1, false);


--
-- Data for Name: professionalratingreply; Type: TABLE DATA; Schema: website; Owner: postgres
--



--
-- Name: professionalratingreply_createdByProfessional_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website."professionalratingreply_createdByProfessional_seq"', 1, true);


--
-- Name: professionalratingreply_replyId_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website."professionalratingreply_replyId_seq"', 1, true);


--
-- Data for Name: userall; Type: TABLE DATA; Schema: website; Owner: postgres
--



--
-- Name: userall_ID_seq; Type: SEQUENCE SET; Schema: website; Owner: postgres
--

SELECT pg_catalog.setval('website."userall_ID_seq"', 6, true);


--
-- Data for Name: usernormal; Type: TABLE DATA; Schema: website; Owner: postgres
--

INSERT INTO website.usernormal VALUES (3, 'admin', '$2y$10$NZF6B30q6/pbZUtZvgpnae2neUQSI8T3aGUvBly.Qp0COo1.x/YXG', 'admin@kniew.com', NULL, NULL, false, 1, '2018-06-15 09:08:09.521842+05:30', '19720e87-1960-f63d-8c51-c8f95442f59c', 1, true, 0, NULL);


--
-- PostgreSQL database dump complete
--

