<?xml version="1.0" encoding="UTF-8"?>
	<xsl:stylesheet version="2.0" xmlns:html="http://www.w3.org/TR/REC-html40" xmlns:sitemap="http://www.sitemaps.org/schemas/sitemap/0.9" sitemap:news="http://www.google.com/schemas/sitemap-news/0.9" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
		<xsl:output method="html" version="1.0" encoding="UTF-8" indent="yes"/>
		<xsl:template match="/">
			<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
					<title>XML Sitemap - UAMS</title>
					<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
					<style type="text/css"> body { background: #f0f0f0; font-family: Helvetica, Arial, sans-serif; font-size: 68.5%; text-align: left; } a { color: black } th {border-bottom: 1px solid #ccc; text-align: left; padding: 15px 5px; font-size: 14px; } table { font-size: 1em; }</style>
				</head>
				<body>
					<h1>XML Sitemap</h1>
					<h2>Generated by <a href="http://www.uams.edu">UAMS</a></h2>
					<table cellpadding="5">
						<tr>
							<th>#</th> <th>URL</th> <th>Priority</th> <th>Change Frequency</th> <th>Last Changed</th>
						</tr>
					<xsl:for-each select="sitemap:urlset/sitemap:url">
						<tr>
							<td><xsl:value-of select="position()"/></td> <td><xsl:variable name="itemURL"><xsl:value-of select="sitemap:loc"/></xsl:variable> <a href="{$itemURL}"><xsl:value-of select="sitemap:loc"/></a> </td> <td><xsl:value-of select="sitemap:priority"/></td> <td><xsl:value-of select="sitemap:changefreq"/></td> <td><xsl:value-of select="sitemap:lastmod"/></td>
						</tr>
					</xsl:for-each>
					</table>
				</body>
			</html>
		</xsl:template>
	</xsl:stylesheet>