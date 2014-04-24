<?php
namespace Craft;

use scssc;

/**
 * Sass_CompilerService is a Craft plugin service that exposes the sass
 * compiler to Sass_CompilerController.
 *
 * @copyright 2014 iMarc LLC
 * @author Kevin Hamer [kh] <kevin@imarc.net>
 */
class Sass_CompilerService extends BaseApplicationComponent
{
	/**
	 * compiler is an instance of scssc;
	 *
	 * @var mixed
	 */
	protected $compiler = null;

	/**
	 * getCompiler() reurns and instance of scssc, constructing one if
	 * necessary.
	 *
	 * @return scssc
	 */
	public function getCompiler()
	{
		if ($this->compiler === null) {
			include dirname(__DIR__) . '/vendor/autoload.php';
			$this->compiler = new scssc();
		}

		return $this->compiler;
	}


	/**
	 * compile() returns the compiled CSS of the SASS source file $filename.
	 *
	 * @param string $filename
	 * @return string
	 */
	public function compile($filename)
	{
		$document_root = dirname(craft()->request->getScriptFile());

		$filename = realpath("$document_root/$filename");

		if (file_exists("$document_root/$filename") && strpos($filename, $document_root) === 0) {
			$scss = file_get_contents("$document_root/$filename");

			$compiler = $this->getCompiler();
			$compiler->setImportPaths($document_root);

			return $compiler->compile($scss);
		}
	}
}
