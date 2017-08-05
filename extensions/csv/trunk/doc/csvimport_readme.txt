How to do a generic CSV import?
-------------------------------

1. Create corresponding class in eZ publish for imported data according to
   the CSV data format. Currently, supported datatype are: integer, 
   float, string, text, xml text, email, boolean.

2. Configure csv.ini under settings.

   2.1 Add the following line under block [CSVImportSettings] in import.ini
       PatternList[]=mypattern
   
   2.2 Create a new block [mypattern] at the end of import.ini

   2.3 Supported settings for block [mypattern]

    [mypattern]
    RootNode=
    CreatorID=
    MatchClassID=
    SectionID=
    FileFieldSeparator=
    Field[1]=
    Field[2]=
    Field[3]=
    ...
    Field[n]=

    StartLine=

    ConvertTag=
    ConvertTagList[sourcetag]=targettag
  
    ParentNodeField=
    ParentNodeFieldID=
    FolderClassID=
    KeyField=
    PrintLogFields=
    
   2.4 Configure [mypattern]
       
       2.4.1 Set RootNode id
	     RootNode defines under which node imported data should be placed. Example:
	     RootNode=2
	     All data will be imported under node 2.
    
       2.4.2 Set CreatorID
	     CreatorID defines who is the creator of those imported data. Note it should
	     be object_id, not node_id. Example:
	     CreatorID=14
	     The creator of content object will be default administrator.
       
       2.4.3 Set MatchClassID
	     Specify which class should be used to create objects for imported data. If you
             have just created the desired class which has id 18, write:
	     MatchClassID=18
       
       2.4.4 Set SectionID
	     Specify section id for imported data. Example:
	     SectionID=1
    
       2.4.5 Set FileFieldSeparator
	     What is the delimiter in the imported CSV data.
             Could be 'tab', ';', ',', '\' or other string separator. Example: 
	     FileFieldSeparator=;
	     
       2.4.6 Set field and class attribute match
	     Specify which field should be imported as which class attribute. Syntax:
	     Field[1-n]=class attribute identifier. If you don't want to import some fields, 
	     leave it empty. Example:
	     Field[1]=name
	     Field[2]=short_description
	     Field[3]=
	     Field[4]=description
	     In this example, field 1 will be imported as name, field 2 will be imported as
	     short_description, field 3 will not be imported and field 4 will be imported as
	     description. 

	     If the CSV data has 10 fields and you only need the 3 first, you cannot skip the 
	     last fields in the ini-file (Field[4] to Field[10])
    
       2.4.7 Set StartLine
	     Specify from which line the data should be imported. Example:
	     StartLine=2
	     Line one will not be imported.
    
       2.4.8 Set ConvertTag to either true or false
	     Define whether or not imported text should be converted using defined rule if the target  
             datatype is xml text field. By default, the standard eZ xml parse will always be used to 
             convert text if the target datatype is xml textfield, so tags like <li>, <b>, 
	     <strong>, <i>, <emphasize>, <header> will be supported automatically either you set
	     ConvertTag to true or false. 
	     
	     Example 1:
	     ConvertTag=true
	     ConvertTagList[sup]=custom
	     ConvertTagList[sub]=custom
	     ConvertTagList[html]=literal
	     In this example settings, <sub>subtext</sub> will be converted to  
	     <custom name='sub'>subtext</custom> 
	     <html><font color='red'>Red text</font></html> will be converted to 
	     <literal class='html'><font color='red'>Red text</font></literal>
	     
	     Example 2:
	     ConvertTag=false
    
       2.4.9 Set ParentNodeField
	     If data contains folder where it should be placed, you should specify which field is the 
	     folder. Example:
	     ParentNodeField=2
	     Then field 2 will be used as folder name and will be created if it does not exist. Imported  
	     data will be placed under corresponding folder the data specifies.

       2.4.10 Set ParentNodeFieldID
	      ParentNodeFieldID identifier the folder which will be used as imported key for created folder.
	      Example:
	      ParentNodeFieldID=3
    
       2.4.11 Set FolderClassID
              Specify which class should be used to create folder. Example:
	      FolderClassID=1
	      The default folder class will be used.

       2.4.12 Set KeyField
	      Specify which field is the primary key of CSV data. Example
	      KeyField=1
              Field 1 will be used as import key. (Eg stored in the objects Remote_id)
    
       2.4.13 Set PrintLogFields
	      Specify which data fields should be printed in the feedback message. Use ';' to 
	      separate fields. Example:
	      PrintLogFields=1;4
	      Field 1 and Field 4 will be printed to feedback message.



3. Goto site/csv/csvimport, select the pattern you have created in step 2 ( mypattern ),
   choose the CSV file and push button 'Run'.

   Please be aware that if you have lots of CSV data, the the import can cause a timeout in
   PHP or Apache which can result in database corruption. In that case it is adviced to use 
   the commandline version. (Example ./extension/csv/import.php (mypattern) (csvfilename))

4. To update what you have imported, goto site/csv/csvimport, select the 
   corresponding pattern, choose CSV file and run import again.


A. Example Usage:
    This is an example with subfolder creation. 
    
    You have the following example data you want to import:
    Category	CatID	Nr	ID	Question	Answer
    Hardware	1	1	1	Why?	Because
    Hardware	1	3	3	Where?	There
    Software	2	1	4	Who?	You
    
    You want the questions and answers to be located in subfolders named by the category field.


    Create a FAQ class with the attributes: category, nr, question, answer. ClassID for FAQ class 
    in this example is 17.
    
    Create a root folder for FAQ. Folder NodeID in this example is 91.
    
    Example ini-file:
	[CSVImportSettings]
	PatternList[]=Faq
	
	[Faq]
        # Node to use as root. In this example a folder with nodeid 91.
        RootNode=91
	# Default admin as creator
        CreatorID=14
	# User created FAQ class to store data in
	MatchClassID=17
	# Store in default section
        SectionID=1
	
        # Tab-delimited CSV-data
        FileFieldSeparator=tab
	
	# Define which fields to store in which attributes. Field 1 in attribute category.. etc
        Field[1]=category
        Field[2]=
        Field[3]=nr
        Field[4]=
        Field[5]=question
        Field[6]=answer
        
	# Skip first line
        StartLine=2

	# No special convertion for textfields (except standard conversion for XML-fields)
        ConvertTag=false
        ConvertTagList[]=

        # KeyField specify which field is the primary key of csv data. Stored in created object remote_id
        KeyField=4

        # Store data in subfolders specified by field 1
        ParentNodeField=1
        # ParentNodeFieldID identifies the primary key of the subfolder. Stored in folder object remote_id
        ParentNodeFieldID=2
        # Specify which class will be used to create folder. Default folder has classID=1
        FolderClassID=1

	# Print fields 1 and 5 when importing
        PrintLogFields=1;5

    Result from import:
	The following content subtree is created:
	
	FAQ/ [Folder]
	    Hardware/ [Folder]
		Hardware1 [FAQ]
		Hardware2 [FAQ]
	    Software/ [Folder]
		Software1 [FAQ]

	In this example the "object name pattern" for the FAQ class was <category><nr>, which can be seen
	in the name of the created FAQ objects.

