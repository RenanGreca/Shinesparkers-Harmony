
images=(0a6903f4aa1fb749b1cd939572e1a0794e926f2e36b4707c29c22394735fcbf4
1e038c7128776f8caa398340316f8bf68cfc912e54681f1b59d9cf1a17646186
1fbe3f108dd3383681091ccb97568a960fe70060cc45c79bb6d576bd048580d8
3a8bc1595403fed08a7cb0539fb64de0d795046d5be26a92bada0e36757f62f0
4d22923da9edc3619c1860fa8a620c8ba5d0e3767b4efe1fac1f4794d6cf5193
5a4488facf00eb27a7041337c5bb16d23c93f124ff64d65c08ca6c8a83904049
5df3237287e230f298afbee1bf733b20a24af58d74b9fa1d011f65b4d3a70568
7b0b63c6b0b9a41e5bf3221703b6a83753b0368b4ab24ed7f6ba68e451ec299b
8e94a554651cb958e90be73bc223c32e22097c92fb7a4883356aa8563ccccb16
8fbec25699df186adea12c6bcba6a122a5469cb5d65bec4585fc90275fa41009
08b05571b0b7770eb75cb5bbf0949b36b00f742c0126c02e3dd19489a39867c9
17a6c5c8f8b7dcc74ada7cc8ce281fe42cf7ae78e0d7bfcfc42359a78904912c
20e4cc61fb597c088c11eeed542c28ff3f40b925f568f5c3d795a9236a810155
60f13c3c38561d36a59e43f8baedebd59af9b3979384f7cf7e7dd39721f5f3dc
083cb398b10ba133c54340e5072ba6f66dfe9ced89111b339cde7e8308614114
97b80f9330638855511dd79fc22ad3033949438a0f39ebf3bf1cc9839e81f8fd
00927613e0345719ec6381180d1fcf8c266f6f423111e1dc64f533d3d928ed1c
b0bd573031b05b92288662bb3deb2b3e1fb35300586a4f6101a8a1d865efab5c
b02e57da09436faa72230fb1134f570f65f472c25953106394656ac80bf6275f
ba7f2a0024b6ed16360c69aceecf78a3cf168e62039b2f0d3a8b28ae4fe435be
bb6626ea846822d6cde06557f6a146392b17409242e6869b5e3086d44b1cd795
d7b696c2a3be0f4955afe5f89806a6dbd06c07631cc611f2b36a5fd557fc7d69
e15ca873ab0804fe14f17a4dd7386d13ac5380389cd16afbcdc855045541f15f
e69f47eed867f1ff4e5c813541b9754ff9786ba0e03a98126dd88db77b536cce
f2e1ca0b4cb5ba58538e5b2c25755a82c6434401f011237003cd5f1b96d82597
f40359a0368a55a11d330f1ea326d194b7dce41a0e7412975699d0c574b412c4
f501382b0ee29af3a0a851bd20d9a90e4b396227ef1e3dfb7e819c0a4ecef57d
harmony-of-shinesparkers_db_data
nintendofusion_db_data
site-luiza-greca_db_data)

for image in ${images[@]}; do
    echo "docker run --rm -i -v=${image}:/tmp/myvolume busybox find /tmp/myvolume"
    docker run --rm -i -v=${image}:/tmp/myvolume busybox find /tmp/myvolume
done;
