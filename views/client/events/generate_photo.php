<?php

// Define file paths
$docxPath = "generated_document.docx";
$imagePath = "./doc-header.png";
$imageName = "doc-header.png";

// Create a temporary directory for the DOCX structure
$tmpDir = "temp_docx_structure";
mkdir($tmpDir);
mkdir($tmpDir . "/word");
mkdir($tmpDir . "/word/media");

// Copy the image into the media folder
copy($imagePath, $tmpDir . "/word/media/" . $imageName);

// Create the document XML content
$documentXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<wp:wordDocument xmlns:wp="http://schemas.openxmlformats.org/wordprocessingml/2006/main">
    <wp:body>
        <wp:p>
            <wp:r>
                <wp:t>Sample Document with Image</wp:t>
            </wp:r>
        </wp:p>
        <wp:p>
            <wp:r>
                <wp:pict>
                    <wp:blip r:embed="r1" />
                </wp:pict>
            </wp:r>
        </wp:p>
    </wp:body>
</wp:wordDocument>';

// Save the document XML
file_put_contents($tmpDir . "/word/document.xml", $documentXML);

// Create the [Content_Types].xml file
$contentTypesXML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
    <Default Extension="xml" ContentType="application/xml"/>
    <Default Extension="jpg" ContentType="image/jpeg"/>
    <Override PartName="/word/document.xml" ContentType="application/vnd.openxmlformats-officedocument.wordprocessingml.document.main+xml"/>
    <Override PartName="/word/media/' . $imageName . '" ContentType="image/png"/>
</Types>';

file_put_contents($tmpDir . "/[Content_Types].xml", $contentTypesXML);

// Create the DOCX file by zipping everything together
$zip = new ZipArchive();
if ($zip->open($docxPath, ZipArchive::CREATE) === TRUE) {
    // Add all files to the zip
    $zip->addFile($tmpDir . "/word/document.xml", "word/document.xml");
    $zip->addFile($tmpDir . "/[Content_Types].xml", "[Content_Types].xml");
    $zip->addFile($tmpDir . "/word/media/" . $imageName, "word/media/" . $imageName);
    $zip->close();
}

// Clean up temporary directory
deleteDirectory($tmpDir);

// Function to delete directory recursively
function deleteDirectory($dir)
{
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? deleteDirectory("$dir/$file") : unlink("$dir/$file");
    }
    rmdir($dir);
}

echo "Document generated: $docxPath";
?>